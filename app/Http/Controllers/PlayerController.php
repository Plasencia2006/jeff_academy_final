<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inscripcion;
use App\Models\Entrenamiento;
use App\Models\Asistencia;
use App\Models\Observacion;
use App\Models\Estadistica;
use App\Models\Anuncio;
use App\Models\ConfiguracionContacto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PlayerController extends Controller
{
    // DASHBOARD PRINCIPAL
    public function dashboard()
    {
        $jugador = Auth::user();
        $inscripcion = Inscripcion::where('jugador_id', $jugador->id)->first();

        // ENTRENAMIENTOS FUTUROS
        $entrenamientos = collect();
        if ($inscripcion) {
            $categoriaNormalizada = Str::of($inscripcion->categoria)->lower()->replace('-', '')->toString();
            $entrenamientos = Entrenamiento::where(function ($q) use ($categoriaNormalizada) {
                $q->whereRaw('LOWER(REPLACE(categoria, "-", "")) = ?', [$categoriaNormalizada]);
            })
            ->whereDate('fecha', '>=', Carbon::today())
            ->orderBy('fecha', 'asc')
            ->get();
        }

        // ASISTENCIAS DEL JUGADOR
        $asistencias = Asistencia::whereHas('inscripcion', function ($query) use ($jugador) {
            $query->where('jugador_id', $jugador->id);
        })
        ->with('inscripcion')
        ->orderBy('fecha', 'desc')
        ->get();

        // EVALUACIONES (OBSERVACIONES TÉCNICAS)
        $observaciones = Observacion::whereHas('inscripcion', function ($query) use ($jugador) {
            $query->where('jugador_id', $jugador->id);
        })
        ->with('inscripcion')
        ->orderBy('fecha', 'desc')
        ->get();

        // RENDIMIENTO (ESTADÍSTICAS)
        $estadisticas = collect();
        $totalGoles = $totalAsistencias = $totalTiros = $totalRecuperaciones = $totalIntercepciones = $totalAtajadas = 0;
        
        if ($inscripcion) {
            $estadisticas = Estadistica::where('inscripcion_id', $inscripcion->id)
                ->orderBy('fecha', 'desc')
                ->get();

            $totalGoles = $estadisticas->sum('goles');
            $totalAsistencias = $estadisticas->sum('asistencias');
            $totalTiros = $estadisticas->sum('tiros_arco');
            $totalRecuperaciones = $estadisticas->sum('recuperaciones');
            $totalIntercepciones = $estadisticas->sum('intercepciones');
            $totalAtajadas = $estadisticas->sum('atajadas');
        }

        // PERFIL DEL JUGADOR
        $perfil = $jugador;
        // Agregar categoría desde la inscripción
        if ($inscripcion) {
            $perfil->categoria = $inscripcion->categoria;
        }

        // DATOS DE PAGOS (Necesario porque la vista se incluye en el dashboard principal)
        // Obtener suscripciones del jugador
        $suscripciones = \App\Models\PlanSubscription::where('user_id', $jugador->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener todas las transacciones de pago
        $pagos = \App\Models\PaymentTransaction::where('user_id', $jugador->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calcular estadísticas de pagos
        $pagosRealizados = $pagos->where('status', 'completed')->count();
        $pagosPendientes = $suscripciones->where('status', 'active')
            ->filter(function($sub) {
                return $sub->end_date && $sub->end_date->diffInDays(now()) <= 7;
            })->count();
        
        $totalPagado = $pagos->where('status', 'completed')->sum('amount');
        
        // Próximo pago (suscripción activa más próxima a vencer)
        $proximoPago = $suscripciones->where('status', 'active')
            ->filter(function($sub) {
                return $sub->end_date && $sub->end_date->isFuture();
            })
            ->sortBy('end_date')
            ->first();
        
        // Estado actual del jugador
        $suscripcionActiva = $suscripciones->where('status', 'active')
            ->filter(function($sub) {
                return $sub->end_date && $sub->end_date->isFuture();
            })
            ->first();
        
        $estadoPagos = 'al_dia';
        if (!$suscripcionActiva) {
            $estadoPagos = 'sin_suscripcion';
        } elseif ($suscripcionActiva->end_date->diffInDays(now()) <= 3) {
            $estadoPagos = 'proximo_vencimiento';
        } elseif ($suscripcionActiva->end_date->isPast()) {
            $estadoPagos = 'vencido';
        }

        // ANUNCIOS PARA EL JUGADOR (por coach y audiencia)
        $anuncios = collect();
        $anunciosImportantes = collect();
        $anunciosNormales = collect();
        
        if ($inscripcion) {
            $categoriaJugador = $inscripcion->categoria ?? '';
            $anuncios = Anuncio::activos()
                ->vigentes()
                ->when(isset($inscripcion->coach_id), function ($q) use ($inscripcion) {
                    $q->where('coach_id', $inscripcion->coach_id);
                })
                ->where(function($query) use ($categoriaJugador) {
                    $query->where('audiencia', 'todos')
                        ->orWhere(function($q) use ($categoriaJugador) {
                            $q->where('audiencia', 'categoria')
                              ->where('categoria', $categoriaJugador);
                        });
                })
                ->orderByRaw("FIELD(prioridad, 'urgente', 'importante', 'normal')")
                ->orderBy('created_at', 'desc')
                ->get();

            $anunciosImportantes = $anuncios->whereIn('prioridad', ['importante', 'urgente']);
            $anunciosNormales = $anuncios->where('prioridad', 'normal');
        }

        // CONFIGURACIÓN DE CONTACTO
        $config = ConfiguracionContacto::obtener();

        // RETORNAR DATOS A LA VISTA
        return view('dashboard.player', compact(
            'jugador',
            'perfil',
            'entrenamientos',
            'asistencias',
            'observaciones',
            'anuncios',
            'anunciosImportantes',
            'anunciosNormales',
            'estadisticas',
            'totalGoles',
            'totalAsistencias',
            'totalTiros',
            'totalRecuperaciones',
            'totalIntercepciones',
            'totalAtajadas',
            // Variables de pagos
            'suscripciones', 
            'pagos',
            'pagosRealizados',
            'pagosPendientes', 
            'totalPagado',
            'proximoPago',
            'suscripcionActiva',
            'estadoPagos',
            'config'
        ));
    }

    // ACTUALIZAR IMAGEN DE PERFIL
    public function updateImage(Request $request)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gravatar_url' => 'nullable|url'
        ]);

        $user = Auth::user();

        // Si se sube una imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($user->foto_perfil && Storage::exists('public/' . $user->foto_perfil)) {
                Storage::delete('public/' . $user->foto_perfil);
            }

            // Guardar nueva imagen
            $path = $request->file('imagen')->store('profiles', 'public');
            $user->update(['foto_perfil' => $path]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Imagen actualizada correctamente'
            ]);
        }

        // Si se usa Gravatar
        if ($request->gravatar_url) {
            // Eliminar imagen local anterior si existe
            if ($user->foto_perfil && Storage::exists('public/' . $user->foto_perfil)) {
                Storage::delete('public/' . $user->foto_perfil);
            }
            
            $user->update(['foto_perfil' => $request->gravatar_url]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Gravatar configurado correctamente'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'No se proporcionó ninguna imagen'
        ], 400);
    }

    // ACTUALIZAR PERFIL DEL JUGADOR
    public function updateProfile(Request $request)
    {
        $request->validate([
            'altura' => 'nullable|numeric|min:0|max:300',
            'peso' => 'nullable|numeric|min:0|max:500',
            'numero_jersey' => 'nullable|string|max:3',
            // Email removido - no se puede actualizar
            'posicion' => 'nullable|string|max:50',
            'categoria' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'biografia' => 'nullable|string|max:1000',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
        ]);

        $user = Auth::user();
        
        // NO actualizar el email
        $user->update([
            'altura' => $request->altura,
            'peso' => $request->peso,
            'numero_jersey' => $request->numero_jersey,
            // 'email' => $request->email, // REMOVIDO
            'posicion' => $request->posicion,
            'categoria' => $request->categoria,
            'telefono' => $request->telefono,
            'biografia' => $request->biografia,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado correctamente'
        ]);
    }

    // MOSTRAR ASISTENCIA DEL JUGADOR CON FILTROS
    


    // MOSTRAR RENDIMIENTO/ESTADÍSTICAS
    public function rendimiento()
    {
        $jugador = Auth::user();
        $inscripcion = Inscripcion::where('jugador_id', $jugador->id)->first();
        
        // Inicializar variables
        $estadisticas = collect();
        $totalGoles = $totalAsistencias = $totalTiros = $totalRecuperaciones = $totalIntercepciones = $totalAtajadas = 0;
        $totalDespejes = $totalEntradas = $totalPasesCompletos = 0;
        $posicionJugador = null;
        
        if ($inscripcion) {
            // Obtener estadísticas del jugador
            $estadisticas = Estadistica::where('inscripcion_id', $inscripcion->id)
                ->orderBy('fecha', 'desc')
                ->get();

            // Calcular totales
            $totalGoles = $estadisticas->sum('goles');
            $totalAsistencias = $estadisticas->sum('asistencias');
            $totalTiros = $estadisticas->sum('tiros_arco');
            $totalRecuperaciones = $estadisticas->sum('recuperaciones');
            $totalIntercepciones = $estadisticas->sum('intercepciones');
            $totalAtajadas = $estadisticas->sum('atajadas');
            $totalDespejes = $estadisticas->sum('despejes');
            $totalEntradas = $estadisticas->sum('entradas');
            $totalPasesCompletos = $estadisticas->sum('pases_completos');
            
            // Obtener posición del jugador
            $posicionJugador = strtolower(trim($jugador->posicion ?? ''));
        }

        return view('dashboard.player.rendimiento', compact(
            'jugador',
            'estadisticas',
            'totalGoles',
            'totalAsistencias', 
            'totalTiros',
            'totalRecuperaciones',
            'totalIntercepciones',
            'totalAtajadas',
            'totalDespejes',
            'totalEntradas',
            'totalPasesCompletos',
            'posicionJugador'
        ));
    }

    // MOSTRAR ANUNCIOS
    public function anuncios()
    {
        $user = Auth::user();
        $inscripcion = Inscripcion::where('jugador_id', $user->id)->first();
        $categoriaJugador = $inscripcion->categoria ?? '';

        $anuncios = Anuncio::activos()
            ->vigentes()
            ->when(isset($inscripcion->coach_id), function ($q) use ($inscripcion) {
                $q->where('coach_id', $inscripcion->coach_id);
            })
            ->where(function($query) use ($categoriaJugador) {
                $query->where('audiencia', 'todos')
                    ->orWhere(function($q) use ($categoriaJugador) {
                        $q->where('audiencia', 'categoria')
                          ->where('categoria', $categoriaJugador);
                    });
            })
            ->orderByRaw("FIELD(prioridad, 'urgente', 'importante', 'normal')")
            ->orderBy('created_at', 'desc')
            ->get();

        $anunciosImportantes = $anuncios->whereIn('prioridad', ['importante', 'urgente']);
        $anunciosNormales = $anuncios->where('prioridad', 'normal');

        return view('dashboard.player.anuncios', compact('anuncios', 'anunciosImportantes', 'anunciosNormales'));
    }

    // MOSTRAR PAGOS DEL JUGADOR
    public function pagos()
    {
        $jugador = Auth::user();
        
        // Obtener suscripciones del jugador
        $suscripciones = \App\Models\PlanSubscription::where('user_id', $jugador->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener todas las transacciones de pago
        $pagos = \App\Models\PaymentTransaction::where('user_id', $jugador->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calcular estadísticas de pagos
        $pagosRealizados = $pagos->where('status', 'completed')->count();
        $pagosPendientes = $suscripciones->where('status', 'active')
            ->filter(function($sub) {
                return $sub->end_date && $sub->end_date->diffInDays(now()) <= 7;
            })->count();
        
        $totalPagado = $pagos->where('status', 'completed')->sum('amount');
        
        // Próximo pago (suscripción activa más próxima a vencer)
        $proximoPago = $suscripciones->where('status', 'active')
            ->filter(function($sub) {
                return $sub->end_date && $sub->end_date->isFuture();
            })
            ->sortBy('end_date')
            ->first();
        
        // Estado actual del jugador
        $suscripcionActiva = $suscripciones->where('status', 'active')
            ->filter(function($sub) {
                return $sub->end_date && $sub->end_date->isFuture();
            })
            ->first();
        
        $estadoPagos = 'al_dia';
        if (!$suscripcionActiva) {
            $estadoPagos = 'sin_suscripcion';
        } elseif ($suscripcionActiva->end_date->diffInDays(now()) <= 3) {
            $estadoPagos = 'proximo_vencimiento';
        } elseif ($suscripcionActiva->end_date->isPast()) {
            $estadoPagos = 'vencido';
        }
        
        return view('dashboard.player.pagos', compact(
            'jugador',
            'suscripciones', 
            'pagos',
            'pagosRealizados',
            'pagosPendientes', 
            'totalPagado',
            'proximoPago',
            'suscripcionActiva',
            'estadoPagos'
        ));
    }
}

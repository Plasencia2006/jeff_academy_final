<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Noticia;
use App\Models\Inscripcion;
use App\Models\Entrenamiento;
use App\Models\Plan;
use App\Models\Disciplina;
use App\Models\PaymentTransaction;
use App\Models\PlanSubscription;
use App\Models\Comunicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Mostrar el dashboard del administrador
     */
    public function dashboard()
    {
        $usuarios = User::whereIn('role', ['player', 'coach'])->get();
        $noticias = Noticia::latest()->get();
        $jugadores = User::where('role', 'player')->get();
        $entrenadores = User::where('role', 'coach')
            ->with(['inscripcionesComoEntrenador.jugador'])
            ->get();
        $padres = User::where('role', 'parent')->get();

        $totalJugadores = $jugadores->count();
        $totalEntrenadores = $entrenadores->count();
        $totalPadres = $padres->count();

        $planes = Plan::all();
        $disciplinas = Disciplina::all();
        $inscripciones = Inscripcion::with(['jugador', 'entrenador'])->latest()->get();

        //OBTENER LOS REGISTROS REALES
        $registros = DB::select("
            SELECT r.*, 
                CASE WHEN ps.user_id IS NOT NULL THEN 1 ELSE 0 END as tiene_plan,
                p.nombre as plan_nombre,
                p.precio as plan_precio,
                p.descripcion as plan_descripcion,
                ps.status as estado_suscripcion,
                ps.start_date as fecha_inicio,
                ps.end_date as fecha_fin,
                ps.stripe_subscription_id
            FROM registros r
            LEFT JOIN plan_subscriptions ps ON r.id = ps.user_id AND ps.status = 'active'
            LEFT JOIN planes p ON ps.plan_id = p.id
            ORDER BY r.id DESC
        ");
        
        //CONVERTIR A COLECCIÓN LARAVEL
        $registros = collect($registros);

        // NUEVAS VARIABLES PARA LAS GRÁFICAS - CORREGIDAS
        // Total de usuarios (de la tabla users)
        $totalUsuarios = User::count();
        
        // Usuarios activos vs inactivos - USANDO SOLO CAMPOS QUE EXISTEN
        // Según tu modelo User, solo existe 'is_active', no 'activo'
        $usuariosActivos = User::where('is_active', true)->count();
        $usuariosInactivos = User::where('is_active', false)->count();
        
        // Porcentajes
        $porcentajeActivos = $totalUsuarios > 0 ? round(($usuariosActivos / $totalUsuarios) * 100, 2) : 0;
        $porcentajeInactivos = $totalUsuarios > 0 ? round(($usuariosInactivos / $totalUsuarios) * 100, 2) : 0;
        
        // Distribución por roles
        $distribucionUsuarios = User::select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->get()
            ->pluck('total', 'role');
        
        // Distribución de planes - MANERA SEGURA
        $suscripcionesActivas = PlanSubscription::where('status', 'active')
            ->where('end_date', '>', now())
            ->get();
        
        $distribucionPlanes = collect();
        foreach ($suscripcionesActivas as $suscripcion) {
            $planNombre = $suscripcion->plan ? $suscripcion->plan->nombre : 'Plan no encontrado';
            $distribucionPlanes->put($planNombre, ($distribucionPlanes->get($planNombre) ?? 0) + 1);
        }
        
        // Distribución de disciplinas
        $distribucionDisciplinas = Inscripcion::select('disciplina', DB::raw('COUNT(*) as total'))
            ->groupBy('disciplina')
            ->get()
            ->pluck('total', 'disciplina');

        // STATS PARA EL HEADER
        try {
            $totalUsuariosHeader = User::count();
        } catch (\Exception $e) {
            $totalUsuariosHeader = 0;
        }
        
        try {
            $inscripcionesActivas = Inscripcion::where('estado', 'activa')->count();
        } catch (\Exception $e) {
            $inscripcionesActivas = 0;
        }
        
        try {
            // Verificar si existe el modelo Pago
            if (class_exists('\App\Models\Pago')) {
                $pagosPendientes = \App\Models\Pago::where('estado', 'pendiente')->count();
            } else {
                $pagosPendientes = 0;
            }
        } catch (\Exception $e) {
            $pagosPendientes = 0;
        }

        //NOTIFICACIONES PARA EL HEADER
        try {
            // Verificar si existe el modelo Anuncio
            if (class_exists('\App\Models\Anuncio')) {
                $notificacionesAdmin = \App\Models\Anuncio::latest()->take(5)->get();
                $contadorNotificaciones = $notificacionesAdmin->count();
            } else {
                $notificacionesAdmin = collect([]);
                $contadorNotificaciones = 0;
            }
        } catch (\Exception $e) {
            $notificacionesAdmin = collect([]);
            $contadorNotificaciones = 0;
        }

        //COMUNICADOS - Filtrar por coach si se especifica
        $comunicadosQuery = Comunicado::with(['remitente', 'destinatario']);
        
        if (request()->has('coach_id') && request()->coach_id != '') {
            $comunicadosQuery->where(function($q) {
                $coachId = request()->coach_id;
                $q->where('destinatario_id', $coachId)
                  ->orWhere('remitente_id', $coachId);
            });
        }
        
        $comunicados = $comunicadosQuery->latest()->get();
        
        // Lista de coaches para el selector
        $coaches = User::where('role', 'coach')->orderBy('name')->get();

        return view('dashboard.admin', compact(
            'usuarios', 
            'noticias',
            'jugadores', 
            'entrenadores', 
            'padres', 
            'totalJugadores', 
            'totalEntrenadores', 
            'totalPadres', 
            'planes', 
            'disciplinas',
            'inscripciones',
            'registros',
            //AGREGAR LAS NUEVAS VARIABLES PARA GRÁFICAS
            'totalUsuarios',
            'usuariosActivos',
            'usuariosInactivos',
            'porcentajeActivos',
            'porcentajeInactivos',
            'distribucionUsuarios',
            'distribucionPlanes',
            'distribucionDisciplinas',
            //AGREGAR VARIABLES PARA EL HEADER
            'totalUsuariosHeader',
            'inscripcionesActivas',
            'pagosPendientes',
            'notificacionesAdmin',
            'contadorNotificaciones',
            'comunicados',
            'coaches'
        ));
    }

    /**
     * Confirmar pago y activar suscripción
     */
    public function confirmarPago(Request $request)
    {
        try {
            $validated = $request->validate([
                'registro_id' => 'required|integer|exists:registros,id',
                'metodo_pago' => 'required|string',
                'observaciones' => 'nullable|string'
            ]);

            $registroId = $validated['registro_id'];
            $metodoPago = $validated['metodo_pago'];
            $observaciones = $validated['observaciones'] ?? '';

            // Obtener el registro
            $registro = DB::table('registros')->where('id', $registroId)->first();
            
            if (!$registro) {
                return response()->json(['success' => false, 'message' => 'Registro no encontrado']);
            }

            // Verificar si ya tiene una suscripción activa
            $suscripcionExistente = \App\Models\PlanSubscription::where('user_id', $registroId)
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->first();

            if ($suscripcionExistente) {
                return response()->json(['success' => false, 'message' => 'El usuario ya tiene una suscripción activa']);
            }

            // Obtener el plan del registro (asumiendo que hay un plan_id en registros o usar un plan por defecto)
            $planId = 1; // Plan por defecto - ajustar según tu lógica
            $plan = \App\Models\Plan::find($planId);
            
            if (!$plan) {
                return response()->json(['success' => false, 'message' => 'Plan no encontrado']);
            }

            DB::beginTransaction();

            // 1. Crear la suscripción
            $suscripcion = \App\Models\PlanSubscription::create([
                'user_id' => $registroId,
                'plan_id' => $planId,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 2. Crear el registro de pago
            \App\Models\PaymentTransaction::create([
                'user_id' => $registroId,
                'plan_id' => $planId,
                'amount' => $plan->precio,
                'currency' => 'PEN',
                'status' => 'completed',
                'payment_method' => $metodoPago,
                'transaction_id' => 'MANUAL_' . time() . '_' . $registroId,
                'metadata' => json_encode([
                    'confirmado_por_admin' => true,
                    'observaciones' => $observaciones,
                    'fecha_confirmacion' => now()->toISOString()
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Pago confirmado y suscripción activada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al confirmar pago: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Registrar pago manual
     */
    public function registrarPagoManual(Request $request)
    {
        try {
            $validated = $request->validate([
                'plan_id' => 'required|integer|exists:planes,id',
                'monto' => 'required|numeric|min:0',
                'metodo' => 'required|string',
                'observaciones' => 'nullable|string'
            ]);

            // Obtener el registro_id desde la URL o parámetro
            $registroId = $request->input('registro_id') ?? $request->route('registro_id');
            
            if (!$registroId) {
                return response()->json(['success' => false, 'message' => 'ID de registro no proporcionado']);
            }

            $planId = $validated['plan_id'];
            $monto = $validated['monto'];
            $metodoPago = $validated['metodo'];
            $observaciones = $validated['observaciones'] ?? '';

            // Verificar que el registro existe
            $registro = DB::table('registros')->where('id', $registroId)->first();
            
            if (!$registro) {
                return response()->json(['success' => false, 'message' => 'Registro no encontrado']);
            }

            // Obtener el plan
            $plan = \App\Models\Plan::find($planId);
            
            if (!$plan) {
                return response()->json(['success' => false, 'message' => 'Plan no encontrado']);
            }

            DB::beginTransaction();

            // 1. Crear la suscripción
            $suscripcion = \App\Models\PlanSubscription::create([
                'user_id' => $registroId,
                'plan_id' => $planId,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 2. Crear el registro de pago
            \App\Models\PaymentTransaction::create([
                'user_id' => $registroId,
                'plan_id' => $planId,
                'amount' => $monto,
                'currency' => 'PEN',
                'status' => 'completed',
                'payment_method' => $metodoPago,
                'transaction_id' => 'MANUAL_' . time() . '_' . $registroId,
                'metadata' => json_encode([
                    'pago_manual' => true,
                    'monto_original_plan' => $plan->precio,
                    'observaciones' => $observaciones,
                    'registrado_por_admin' => true,
                    'fecha_registro' => now()->toISOString()
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Pago registrado y suscripción activada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al registrar pago manual: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Registrar un nuevo usuario (desde admin)
     */
    public function storeUsuario(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255', 
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'telefono' => 'nullable|string|max:20',
            'tipo_usuario' => 'required|in:jugador,entrenador,padre',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'required|string',
            // Hacer registro_id opcional para entrenadores
            'registro_id' => 'nullable|exists:registros,id',
        ]);

        // MAPEO CORREGIDO
        $roleMap = [
            'jugador' => 'player',
            'entrenador' => 'coach', 
            'padre' => 'parent'
        ];

        try {
            $userData = [
                'name' => $validated['nombres'] . ' ' . $validated['apellido_paterno'] . ' ' . $validated['apellido_materno'],
                'nombres' => $validated['nombres'],
                'apellido_paterno' => $validated['apellido_paterno'],
                'apellido_materno' => $validated['apellido_materno'],
                'documento' => $request->documento,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'telefono' => $validated['telefono'],
                'role' => $roleMap[$validated['tipo_usuario']],
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
                'genero' => $validated['genero'],
                'estado' => 'activo',
                'is_active' => 1,
            ];

            // Solo asignar registro_id si es jugador y está presente
            if ($validated['tipo_usuario'] === 'jugador' && isset($validated['registro_id'])) {
                $userData['registro_id'] = $validated['registro_id'];
            }

            User::create($userData);

            return redirect()->back()->with('success', 'Usuario creado correctamente.');

        } catch (\Exception $e) {
            \Log::error('Error creando usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el usuario: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Editar un usuario
     */
    public function updateUsuario(Request $request, $id)
    {
        Log::info('Actualizando usuario', ['id' => $id, 'data' => $request->all()]);

        $usuario = User::findOrFail($id);

        $request->validate([
            'nombres' => 'nullable|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'documento' => 'nullable|string|max:20',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($usuario->id)
            ],
            'telefono' => 'nullable|string|max:20',
            'genero' => 'nullable|in:masculino,femenino',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        try {
            // Construir el nombre completo si se proporcionan nombres y apellidos
            $name = $usuario->name;
            if ($request->nombres || $request->apellido_paterno) {
                $name = trim(($request->nombres ?? '') . ' ' . ($request->apellido_paterno ?? '') . ' ' . ($request->apellido_materno ?? ''));
            } elseif ($request->nombre) {
                $name = $request->nombre;
            }

            $dataToUpdate = [
                'name' => $name,
                'email' => $request->email,
                'telefono' => $request->telefono ?? null,
                'fecha_nacimiento' => $request->fecha_nacimiento ?? null,
                // Asumiendo que estos campos existen en la BD o se ignorarán si no están en $fillable
                'nombres' => $request->nombres,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'documento' => $request->documento,
                'genero' => $request->genero,
            ];

            // Filtrar campos nulos o vacíos si es necesario, o dejar que Eloquent maneje los fillables
            $usuario->fill($dataToUpdate);
            $usuario->save();

            Log::info('Usuario actualizado exitosamente', ['id' => $usuario->id]);

            return redirect()->back()->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar contraseña de un usuario (desde admin)
     */
    public function updatePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $user = User::findOrFail($id);

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la contraseña: ' . $e->getMessage());
        }
    }

    /**
     * Desactivar/activar un usuario (toggle por estado)
     */
    public function destroyUsuario($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->estado = $user->estado == 'activo' ? 'inactivo' : 'activo';
            $user->save();

            return redirect()->to(url()->previous() . '#usuarios')
                ->with('success', 'El estado del usuario se ha actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(url()->previous() . '#usuarios')
                ->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar permanentemente un usuario
     */
    public function deleteUsuario($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Verificar que no sea el usuario actual
            if ($user->id === auth()->id()) {
                return back()->with('error', 'No puedes eliminar tu propia cuenta.');
            }

            // Eliminar inscripciones relacionadas
            $user->inscripciones()->delete();
            
            // Eliminar entrenamientos relacionados (si es entrenador)
            if ($user->role === 'coach') {
                $user->entrenamientos()->delete();
            }

            // Eliminar el usuario
            $user->delete();

            return back()->with('success', 'Usuario eliminado permanentemente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    // ============================================
    // INSCRIPCIONES
    // ============================================

    /**
     * Registrar una nueva inscripción
     */
    public function storeInscripcion(Request $request)
    {
        $validated = $request->validate([
            'jugador_id' => 'required|exists:users,id',
            'entrenador_id' => 'nullable|exists:users,id',
            'disciplina' => 'required|string',
            'categoria' => 'required|string',
            'tipo_entrenamiento' => 'required|string',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        try {
            // Verificar si el jugador ya tiene un entrenador asignado
            if (!empty($validated['entrenador_id'])) {
                $inscripcionExistente = Inscripcion::where('jugador_id', $validated['jugador_id'])
                    ->whereNotNull('entrenador_id')
                    ->first();

                if ($inscripcionExistente) {
                    return back()->with('error', 'El jugador ya está asignado a un entrenador (' . ($inscripcionExistente->entrenador->name ?? 'Desconocido') . ')');
                }
            }

            Inscripcion::create($validated);
            return back()->with('success', 'Inscripción registrada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar la inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar una inscripción existente
     */
    public function updateInscripcion(Request $request, $id)
    {
        $inscripcion = Inscripcion::findOrFail($id);

        $validated = $request->validate([
            'entrenador_id' => 'nullable|exists:users,id',
            'disciplina' => 'required|string',
            'categoria' => 'required|string',
            'tipo_entrenamiento' => 'required|string',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        try {
            $inscripcion->update($validated);
            return back()->with('success', 'Inscripción actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Aprobar una inscripción
     */
    public function aprobarInscripcion($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->update(['estado' => 'aprobada']);

        return back()->with('success', 'Inscripción aprobada');
    }

    /**
     * Rechazar una inscripción
     */
    public function rechazarInscripcion($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->update(['estado' => 'rechazada']);

        return back()->with('success', 'Inscripción rechazada');
    }

    /**
     * Eliminar una inscripción
     */
    public function destroyInscripcion($id)
    {
        try {
            $inscripcion = Inscripcion::findOrFail($id);
            $inscripcion->delete();

            return back()->with('success', 'Inscripción eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un registro de la tabla registros
     */
    public function destroyRegistro($id)
    {
        try {
            DB::beginTransaction();
            
            // Verificar que el registro existe
            $registro = DB::table('registros')->where('id', $id)->first();
            
            if (!$registro) {
                return back()->with('error', 'Registro no encontrado');
            }
            
            // Eliminar suscripciones relacionadas
            PlanSubscription::where('user_id', $id)->delete();
            
            // Eliminar transacciones de pago relacionadas
            PaymentTransaction::where('user_id', $id)->delete();
            
            // Eliminar el registro
            DB::table('registros')->where('id', $id)->delete();
            
            DB::commit();
            
            return back()->with('success', 'Registro eliminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }

    // ============================================
    // ENTRENAMIENTOS
    // ============================================

    /**
     * Registrar un nuevo entrenamiento
     */
    public function storeEntrenamiento(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'disciplina' => 'required|string',
            'categoria' => 'required|string',
            'tipo' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'duracion' => 'required|integer|min:15|max:180',
            'ubicacion' => 'required|string',
            'objetivos' => 'required|string',
        ]);

        try {
            Entrenamiento::create($validated);
            return back()->with('success', 'Entrenamiento registrado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar el entrenamiento: ' . $e->getMessage());
        }
    }

    /**
     * Editar un entrenamiento
     */
    public function updateEntrenamiento(Request $request, $id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'disciplina' => 'required|string',
            'categoria' => 'required|string',
            'tipo' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'duracion' => 'required|integer|min:15|max:180',
            'ubicacion' => 'required|string',
            'objetivos' => 'required|string',
        ]);

        $entrenamiento->update($validated);

        return back()->with('success', 'Entrenamiento actualizado correctamente');
    }

    /**
     * Cancelar un entrenamiento
     */
    public function cancelarEntrenamiento($id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);
        $entrenamiento->delete();

        return back()->with('success', 'Entrenamiento cancelado');
    }

    // ============================================
    // NOTICIAS
    // ============================================

    /**
     * Publicar una nueva noticia
     */
    public function storeNoticia(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string|in:general,torneo,entrenamiento,logro',
            'imagen' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'fecha' => 'required|date',
        ]);

        try {
            if ($request->hasFile('imagen')) {
                $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
            } else {
                $validated['imagen'] = 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80';
            }

            Noticia::create($validated);

            return back()->with('success', 'Noticia publicada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al publicar la noticia: ' . $e->getMessage());
        }
    }

    /**
     * Editar una noticia existente
     */
    public function updateNoticia(Request $request, $id)
    {
        $noticia = Noticia::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string|in:general,torneo,entrenamiento,logro',
            'imagen' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'fecha' => 'required|date',
        ]);

        try {
            if ($request->hasFile('imagen')) {
                if ($noticia->imagen && strpos($noticia->imagen, 'noticias/') !== false) {
                    Storage::disk('public')->delete($noticia->imagen);
                }
                $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
            }

            $noticia->update($validated);

            return back()->with('success', 'Noticia actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la noticia: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una noticia
     */
    public function destroyNoticia($id)
    {
        $noticia = Noticia::findOrFail($id);

        try {
            if ($noticia->imagen && strpos($noticia->imagen, 'noticias/') !== false) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $noticia->delete();

            return back()->with('success', 'Noticia eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la noticia: ' . $e->getMessage());
        }
    }

    // ============================================
    // PLANES
    // ============================================

    /**
     * Crear un plan
     */
    public function storePlan(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'duracion' => 'required|integer|min:1',
            'tipo' => 'required|string|in:basico,premium,vip',
            'descripcion' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'estado' => 'required|string|in:activo,inactivo',
            'disciplinas' => 'nullable|array',
        ]);

        try {
            if (isset($validated['disciplinas'])) {
                $validated['disciplinas'] = implode(',', $validated['disciplinas']);
            }

            Plan::create($validated);

            return back()->with('success', 'Plan creado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el plan: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar un plan
     */
    public function updatePlan(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'duracion' => 'required|integer|min:1',
            'tipo' => 'required|string|in:basico,premium,vip',
            'descripcion' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'estado' => 'required|string|in:activo,inactivo',
            'disciplinas' => 'nullable|array',
        ]);

        try {
            if (isset($validated['disciplinas'])) {
                $validated['disciplinas'] = implode(',', $validated['disciplinas']);
            }

            $plan->update($validated);

            return back()->with('success', 'Plan actualizado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el plan: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un plan
     */
    public function destroyPlan($id)
    {
        $plan = Plan::findOrFail($id);

        try {
            $plan->delete();
            return back()->with('success', 'Plan eliminado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el plan: ' . $e->getMessage());
        }
    }

    // ============================================
    // DISCIPLINAS
    // ============================================

    /**
     * Registrar una nueva disciplina
     */
    public function storeDisciplina(Request $request)
    {
        Log::info('=== INICIANDO storeDisciplina ===');
        Log::info('Datos del request:', $request->all());

        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'categoria' => 'required|string|in:Fútbol,Voley',
                'edad_minima' => 'nullable|integer|min:0',
                'edad_maxima' => 'nullable|integer|min:0',
                'cupo_maximo' => 'nullable|integer|min:1',
                'descripcion' => 'nullable|string',
                'requisitos' => 'nullable|string',
                'estado' => 'required|string|in:activa,inactiva',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            Log::info('Datos validados:', $validated);

            if ($request->hasFile('imagen')) {
                $path = $request->file('imagen')->store('disciplinas', 'public');
                $validated['imagen'] = $path;
                Log::info('Imagen guardada en: ' . $path);
            }

            $disciplina = Disciplina::create($validated);
            Log::info('Disciplina creada exitosamente: ' . $disciplina->id);

            return back()->with('success', 'Disciplina creada correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error general en storeDisciplina:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Error al crear la disciplina: ' . $e->getMessage())->withInput();
        }
    }

    public function updateDisciplina(Request $request, $id)
    {
        $disciplina = Disciplina::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|in:Fútbol,Voley',
            'edad_minima' => 'nullable|integer|min:0',
            'edad_maxima' => 'nullable|integer|min:0',
            'cupo_maximo' => 'nullable|integer|min:1',
            'descripcion' => 'nullable|string',
            'requisitos' => 'nullable|string',
            'estado' => 'required|string|in:activa,inactiva',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            if ($request->hasFile('imagen')) {
                if ($disciplina->imagen && Storage::disk('public')->exists($disciplina->imagen)) {
                    Storage::disk('public')->delete($disciplina->imagen);
                }
                $validated['imagen'] = $request->file('imagen')->store('disciplinas', 'public');
            } else {
                $validated['imagen'] = $disciplina->imagen;
            }

            $disciplina->update($validated);

            return back()->with('success', 'Disciplina actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la disciplina: ' . $e->getMessage());
        }
    }

    public function destroyDisciplina($id)
    {
        $disciplina = Disciplina::findOrFail($id);

        try {
            $disciplina->delete();
            return back()->with('success', 'Disciplina eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la disciplina: ' . $e->getMessage());
        }
    }

    // ============================================
    // REPORTES
    // ============================================

    public function generarReporte(Request $request)
    {
        $validated = $request->validate([
            'tipo_reporte' => 'required|in:asistencia,rendimiento,financiero,inscripciones',
            'rango_fecha' => 'required|in:semanal,mensual,trimestral,anual,personalizado',
            'fecha_inicio' => 'nullable|required_if:rango_fecha,personalizado|date',
            'fecha_fin' => 'nullable|required_if:rango_fecha,personalizado|date',
            'disciplina' => 'nullable|string',
            'categoria' => 'nullable|string',
        ]);

        try {
            // Aquí podrías construir y devolver un reporte real (PDF, CSV, etc.)
            return back()->with('success', 'Reporte generado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }

    // ============================================
    // PAGOS / SUSCRIPCIONES
    // ============================================

    /**
     * Vista de gestión de pagos
     */
    public function gestionPagos()
    {
        $pagos = PaymentTransaction::with(['user', 'subscription.plan'])->latest()->get();

        $estadisticas = [
            'completados' => PaymentTransaction::where('status', 'completed')->count(),
            'pendientes' => PaymentTransaction::where('status', 'pending')->count(),
            'fallidos' => PaymentTransaction::where('status', 'failed')->count(),
            'total_recaudado' => PaymentTransaction::where('status', 'completed')->sum('amount'),
        ];

        return view('admin.pagos', compact('pagos', 'estadisticas'));
    }

    public function detallePago($id)
    {
        $pago = PaymentTransaction::with(['user', 'subscription.plan'])->findOrFail($id);
        return view('admin.pago-detalle', compact('pago'));
    }

    public function suspenderSuscripcion($id)
    {
        $suscripcion = PlanSubscription::findOrFail($id);
        $suscripcion->update(['status' => 'canceled']);

        // Opcional: desactivar usuario si tu modelo tiene este método
        if (method_exists($suscripcion->user, 'deactivateAccount')) {
            $suscripcion->user->deactivateAccount();
        }

        return back()->with('success', 'Suscripción suspendida correctamente.');
    }

    public function activarSuscripcion($id)
    {
        $suscripcion = PlanSubscription::findOrFail($id);
        $suscripcion->update(['status' => 'active']);

        if (method_exists($suscripcion->user, 'activateAccount')) {
            $suscripcion->user->activateAccount();
        }

        return back()->with('success', 'Suscripción activada correctamente.');
    }

    public function extenderSuscripcion(Request $request, $id)
    {
        $request->validate([
            'meses_extra' => 'required|integer|min:1|max:12'
        ]);

        $suscripcion = PlanSubscription::findOrFail($id);

        // Asegurarse de que end_date sea una instancia de Carbon
        try {
            $endDate = $suscripcion->end_date ? \Carbon\Carbon::parse($suscripcion->end_date) : now();
            $suscripcion->update([
                'end_date' => $endDate->addMonths($request->meses_extra)->toDateString()
            ]);

            return back()->with('success', "Suscripción extendida por {$request->meses_extra} meses.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al extender la suscripción: ' . $e->getMessage());
        }
    }

    /**
     * Helper para redirigir a la sección del dashboard
     */
    private function redirectToSection($request, $defaultSection = 'inicio')
    {
        $section = $request->input('section', $defaultSection);
        return redirect()->route('admin.dashboard', ['section' => $section]);
    }

    // ============================================
    // ENVIAR CREDENCIALES POR EMAIL
    // ============================================

    public function enviarCredenciales(Request $request)
    {
        try {
            $usuario = User::findOrFail($request->usuario_id);

            $data = [
                'usuario' => $usuario,
                'password_enviar' => $request->password,
                'mensaje_personalizado' => $request->mensaje
            ];

            Mail::send('emails.credenciales', $data, function ($message) use ($usuario) {
                $message->to($usuario->email, $usuario->name)
                    ->subject('Credenciales de Acceso - ' . config('app.name'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Credenciales enviadas correctamente',
                'email' => $usuario->email
            ]);
        } catch (\Exception $e) {
            Log::error('Error enviando credenciales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar perfil del administrador
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        try {
            // Manejar foto de perfil
            if ($request->hasFile('foto_perfil')) {
                // Eliminar foto anterior si existe
                if ($user->foto_perfil && Storage::exists('public/' . $user->foto_perfil)) {
                    Storage::delete('public/' . $user->foto_perfil);
                }
                
                // Guardar nueva foto
                $path = $request->file('foto_perfil')->store('profiles', 'public');
                $user->foto_perfil = $path;
            }

            // Actualizar datos básicos
            $user->name = $request->name;
            $user->email = $request->email;

            // Cambiar contraseña si se proporciona
            if ($request->filled('password')) {
                // Verificar contraseña actual
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->with('error', 'La contraseña actual no es correcta.');
                }
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return back()->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }
    }

    // ============================================
    // CONFIGURACIÓN DE CONTACTO
    // ============================================

    /**
     * Mostrar formulario de configuración de contacto
     */
    public function editarUbicacion()
    {
        $config = \App\Models\ConfiguracionContacto::obtener();
        return view('dashboard.admin.ubicacion', compact('config'));
    }

    /**
     * Actualizar configuración de contacto
     */
    public function actualizarContacto(Request $request)
    {
        $validated = $request->validate([
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'horario_semana' => 'required|string|max:100',
            'horario_sabado' => 'required|string|max:100',
            'horario_domingo' => 'nullable|string|max:100',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'mapa_url' => 'nullable|url',
        ]);

        try {
            $config = \App\Models\ConfiguracionContacto::first();
            
            if ($config) {
                $config->update($validated);
            } else {
                \App\Models\ConfiguracionContacto::create($validated);
            }

            return back()->with('success', 'Configuración de contacto actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar configuración de contacto: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar la configuración: ' . $e->getMessage());
        }
    }
}

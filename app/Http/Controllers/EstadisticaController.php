<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstadisticaController extends Controller
{
    /**
     * Mostrar la página principal de estadísticas
     */
    public function index()
    {
        try {
            // Obtener todas las inscripciones activas con sus jugadores
            $inscripciones = Inscripcion::with('jugador')
                ->whereHas('jugador', function($query) {
                    $query->where('activo', true);
                })
                ->get();

            // Obtener estadísticas con relaciones
            $estadisticas = Estadistica::with(['inscripcion.jugador'])
                ->orderBy('fecha', 'desc')
                ->get();

            // Calcular datos agregados por jugador
            $jugadoresData = $inscripciones->map(function ($inscripcion) {
                $stats = Estadistica::where('inscripcion_id', $inscripcion->id)->get();
                
                return [
                    'jugador' => $inscripcion->jugador,
                    'inscripciones' => collect([$inscripcion]),
                    'total_goles' => $stats->sum('goles'),
                    'total_asistencias' => $stats->sum('asistencias'),
                    'total_partidos' => $stats->count(),
                ];
            });

            return view('estadisticas', compact('inscripciones', 'estadisticas', 'jugadoresData'));
            
        } catch (\Exception $e) {
            Log::error('Error en EstadisticaController@index: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar las estadísticas: ' . $e->getMessage());
        }
    }

    /**
     * Guardar nuevas estadísticas
     */
    public function store(Request $request)
    {
        // Log de los datos recibidos para debugging
        Log::info('Datos recibidos en store:', $request->all());

        try {
            // Validar los datos
            $validated = $request->validate([
                'inscripcion_id' => 'required|exists:inscripciones,id',
                'fecha' => 'required|date',
                'posicion' => 'required|in:portero,defensa,mediocampista,delantero',
                'categoria' => 'nullable|string',
                // Estadísticas defensivas
                'atajadas' => 'nullable|integer|min:0',
                'despejes' => 'nullable|integer|min:0',
                'recuperaciones' => 'nullable|integer|min:0',
                'intercepciones' => 'nullable|integer|min:0',
                'entradas' => 'nullable|integer|min:0',
                // Estadísticas ofensivas
                'pases_completos' => 'nullable|integer|min:0',
                'asistencias' => 'nullable|integer|min:0',
                'goles' => 'nullable|integer|min:0',
                'tiros_arco' => 'nullable|integer|min:0',
                'observaciones' => 'nullable|string|max:500'
            ], [
                'inscripcion_id.required' => 'Debe seleccionar un jugador.',
                'inscripcion_id.exists' => 'El jugador seleccionado no existe.',
                'fecha.required' => 'La fecha es obligatoria.',
                'fecha.date' => 'La fecha no es válida.',
                'posicion.required' => 'La posición es obligatoria.',
                'posicion.in' => 'La posición debe ser: portero, defensa, mediocampista o delantero.',
            ]);

            Log::info('Datos validados correctamente:', $validated);

            // Crear el registro
            $estadistica = Estadistica::create($validated);

            if ($estadistica && $estadistica->id) {
                Log::info('Estadística creada con ID: ' . $estadistica->id);
                return redirect()->back()->with('success', '¡Estadísticas guardadas correctamente!');
            }

            Log::warning('No se pudo crear la estadística (sin ID)');
            return redirect()->back()->with('error', 'No se pudo guardar las estadísticas. Inténtalo nuevamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error de validación
            Log::error('Error de validación:', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario.');

        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al guardar estadísticas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * Obtener datos del jugador via AJAX
     */
    public function getJugadorData($inscripcionId)
    {
        try {
            $inscripcion = Inscripcion::with('jugador')->findOrFail($inscripcionId);
            $jugador = $inscripcion->jugador;
            
            if (!$jugador) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el jugador asociado a esta inscripción'
                ], 404);
            }

            // Normalizar la posición a minúsculas
            $posicion = $jugador->posicion ? strtolower(trim($jugador->posicion)) : null;
            
            return response()->json([
                'success' => true,
                'posicion' => $posicion,
                'categoria' => $inscripcion->categoria ?? null,
                'jugador_nombre' => $jugador->name ?? null
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la inscripción especificada'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error en getJugadorData: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos del jugador: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar estadísticas existentes
     */
    public function update(Request $request, $id)
    {
        try {
            $estadistica = Estadistica::findOrFail($id);
            
            $validated = $request->validate([
                'fecha' => 'required|date',
                'posicion' => 'required|in:portero,defensa,mediocampista,delantero',
                'categoria' => 'nullable|string',
                'atajadas' => 'nullable|integer|min:0',
                'despejes' => 'nullable|integer|min:0',
                'recuperaciones' => 'nullable|integer|min:0',
                'intercepciones' => 'nullable|integer|min:0',
                'entradas' => 'nullable|integer|min:0',
                'pases_completos' => 'nullable|integer|min:0',
                'asistencias' => 'nullable|integer|min:0',
                'goles' => 'nullable|integer|min:0',
                'tiros_arco' => 'nullable|integer|min:0',
                'observaciones' => 'nullable|string|max:500'
            ]);

            $estadistica->update($validated);

            return redirect()->back()->with('success', 'Estadísticas actualizadas correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al actualizar estadísticas: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar estadísticas
     */
    public function destroy($id)
    {
        try {
            $estadistica = Estadistica::findOrFail($id);
            $estadistica->delete();

            return redirect()->back()->with('success', 'Estadísticas eliminadas correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al eliminar estadísticas: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}

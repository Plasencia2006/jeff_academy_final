<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Inscripcion;
use App\Models\User;
use App\Models\Entrenamiento;
use App\Models\Observacion;
use App\Models\Anuncio;
use App\Models\Comunicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Muestra el panel principal del entrenador (dashboard completo).
     */
    public function index()
    {
        // Trae solo las inscripciones asignadas al entrenador autenticado
        $inscripciones = Inscripcion::with('jugador')
            ->where('entrenador_id', Auth::id())
            ->get();

        // Trae los entrenadores para el selector de "Programar entrenamiento"
        $entrenadores = User::where('role', 'coach')->get();

        // Entrenamientos creados por el coach autenticado
        $entrenamientos = Entrenamiento::where('entrenador_id', Auth::id())
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->get();

        // Jugadores bajo este entrenador con sus inscripciones y estadísticas
        $jugadoresData = Inscripcion::where('entrenador_id', Auth::id())
            ->with(['jugador', 'estadisticas', 'asistencias'])
            ->get()
            ->groupBy('jugador_id')
            ->map(function ($inscripciones) {
                $jugador = $inscripciones->first()->jugador;
                $totalEstadisticas = $inscripciones->flatMap->estadisticas;
                $totalAsistencias = $inscripciones->flatMap->asistencias;

                return [
                    'jugador' => $jugador,
                    'inscripciones' => $inscripciones,
                    'total_goles' => $totalEstadisticas->sum('goles'),
                    'total_asistencias' => $totalEstadisticas->sum('asistencias'),
                    'total_partidos' => $totalEstadisticas->count(),
                    'asistencias_registradas' => $totalAsistencias->count(),
                    'asistencias_presentes' => $totalAsistencias->where('estado', 'presente')->count(),
                ];
            });

        // Historial de asistencias registradas por este entrenador
        $asistenciasHistorial = Asistencia::whereHas('inscripcion', function ($query) {
            $query->where('entrenador_id', Auth::id());
        })
        ->with(['inscripcion.jugador'])
        ->orderBy('fecha', 'desc')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($asistencia) {
            return [
                'id' => $asistencia->id,
                'fecha' => $asistencia->fecha,
                'jugador_nombre' => $asistencia->inscripcion->jugador->name ?? 'N/A',
                'jugador_foto' => $asistencia->inscripcion->jugador->foto_perfil 
                    ? asset('storage/' . $asistencia->inscripcion->jugador->foto_perfil) 
                    : null,
                'categoria' => $asistencia->inscripcion->categoria ?? 'N/A',
                'estado' => $asistencia->estado,
                'observaciones' => $asistencia->observaciones,
                'fecha_registro' => $asistencia->created_at->format('Y-m-d H:i'),
            ];
        });

        // Observaciones técnicas (para sección de Observaciones)
        $observaciones = Observacion::with(['inscripcion.jugador'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Anuncios del coach autenticado
        $anuncios = Anuncio::where('coach_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Comunicados - Solo los que son para este coach o enviados por este coach
        $comunicados = Comunicado::with(['remitente', 'destinatario'])
            ->where(function($q) {
                $q->where('destinatario_id', Auth::id())
                  ->orWhere('remitente_id', Auth::id());
            })
            ->latest()
            ->get();

        // Estadísticas - Para el historial de estadísticas
        $estadisticas = \App\Models\Estadistica::with(['inscripcion.jugador'])
            ->whereHas('inscripcion', function($query) {
                $query->where('entrenador_id', Auth::id());
            })
            ->orderBy('fecha', 'desc')
            ->get();

        // Retorna el dashboard con todos los datos listos
        return view('dashboard.coach', compact(
            'inscripciones',
            'entrenadores',
            'entrenamientos',
            'jugadoresData',
            'asistenciasHistorial',
            'observaciones',
            'anuncios',
            'comunicados',
            'estadisticas'
        ));
    }

    /**
     * Guarda las asistencias registradas por el entrenador.
     */
    public function store(Request $request)
    {
        // Validar que venga el array de asistencias
        $request->validate([
            'asistencias' => 'required|array',
        ]);

        // Guardar cada asistencia enviada desde el formulario
        foreach ($request->asistencias as $inscripcion_id => $data) {

            // Validar estado recibido
            $estado = strtolower($data['estado'] ?? 'presente');
            if (!in_array($estado, ['presente', 'ausente', 'tarde'])) {
                $estado = 'presente';
            }

            Asistencia::create([
                'inscripcion_id' => $inscripcion_id,
                'estado' => $estado,
                'observaciones' => $data['observaciones'] ?? null,
                'fecha' => $request->fecha ?? now()->toDateString(),
            ]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', '✅ Asistencias registradas correctamente.');
    }
}

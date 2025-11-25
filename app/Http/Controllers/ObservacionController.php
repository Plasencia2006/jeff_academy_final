<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class ObservacionController extends Controller
{
    /**
     * Mostrar vista de observaciones con lista de jugadores
     */
    public function index()
    {
        // Traer inscripciones disponibles para seleccionar
        $inscripciones = Inscripcion::with('jugador')->get();

        // Traer observaciones registradas
        $observaciones = Observacion::with('inscripcion.jugador')
            ->latest()
            ->get();

        return view('dashboard.coach.observaciones', compact('inscripciones', 'observaciones'));
    }

    /**
     * Guardar observación
     */
    public function store(Request $request)
    {
        $request->validate([
            'inscripcion_id' => 'required|exists:inscripciones,id',
            'fecha' => 'required|date',
            'aspecto' => 'required|string',
            'detalle' => 'required|string',
            'recomendaciones' => 'nullable|string',
        ]);

        Observacion::create([
            'inscripcion_id' => $request->inscripcion_id,
            'fecha' => $request->fecha,
            'aspecto' => $request->aspecto,
            'detalle' => $request->detalle,
            'recomendaciones' => $request->recomendaciones,
        ]);

        return redirect()->back()->with('success', '✅ Observación guardada correctamente.');
    }

    /**
     * Actualizar observación
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'inscripcion_id' => 'required|exists:inscripciones,id',
            'fecha' => 'required|date',
            'aspecto' => 'required|string',
            'detalle' => 'required|string',
            'recomendaciones' => 'nullable|string',
        ]);

        $observacion = Observacion::findOrFail($id);
        $observacion->update([
            'inscripcion_id' => $request->inscripcion_id,
            'fecha' => $request->fecha,
            'aspecto' => $request->aspecto,
            'detalle' => $request->detalle,
            'recomendaciones' => $request->recomendaciones,
        ]);

        return redirect()->back()->with('success', '✅ Observación actualizada correctamente.');
    }

    /**
     * Eliminar observación
     */
    public function destroy($id)
    {
        $observacion = Observacion::findOrFail($id);
        $observacion->delete();
        
        return redirect()->back()->with('success', '✅ Observación eliminada correctamente.');
    }
}
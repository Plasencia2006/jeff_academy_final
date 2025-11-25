<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrenamiento;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EntrenamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Guardar un entrenamiento programado desde el panel del coach.
     */
    public function storeFromCoach(Request $request)
    {
        $validated = $request->validate([
            'categoria' => ['required','string'],
            'tipo' => ['required','string'],
            'fecha' => ['required','date'],
            'hora_inicio' => ['required','date_format:H:i'],
            'hora_fin' => ['required','date_format:H:i','after:hora_inicio'],
            'ubicacion' => ['required','string'],
            'entrenador_id' => ['nullable','exists:users,id'],
            'objetivos' => ['nullable','string'],
            'disciplina' => ['nullable','string'],
        ]);

        // Calcular hora y duración (minutos)
        $inicio = Carbon::createFromFormat('H:i', $validated['hora_inicio']);
        $fin = Carbon::createFromFormat('H:i', $validated['hora_fin']);
        $duracion = $inicio->diffInMinutes($fin);

        // Validar que no haya otro entrenamiento en el mismo horario
        try {
            Entrenamiento::create([
                'nombre' => 'Entrenamiento programado',
                'disciplina' => strtolower($validated['disciplina'] ?? 'futbol'),
                'categoria' => strtolower($validated['categoria']),
                'tipo' => strtolower($validated['tipo']),
                'fecha' => $validated['fecha'],
                'hora' => $validated['hora_inicio'],
                'duracion' => $duracion,
                'ubicacion' => strtolower($validated['ubicacion']),
                'objetivos' => $validated['objetivos'] ?? 'N/A',
                'entrenador_id' => $validated['entrenador_id'] ?? Auth::id(),
            ]);

            return back()->with('success', 'Entrenamiento programado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo programar el entrenamiento.');
        }
    }

    /**
     * Actualizar un entrenamiento del coach autenticado.
     */
    public function updateFromCoach(Request $request, Entrenamiento $entrenamiento)
    {
        // Autorizar: solo el dueño (entrenador) puede editar
        // Si es un registro antiguo sin entrenador asignado, lo asignamos al actual
        if (is_null($entrenamiento->entrenador_id)) {
            $entrenamiento->entrenador_id = Auth::id();
            $entrenamiento->save();
        } elseif ($entrenamiento->entrenador_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'categoria' => ['required','string'],
            'tipo' => ['required','string'],
            'fecha' => ['required','date'],
            'hora_inicio' => ['required','date_format:H:i'],
            'hora_fin' => ['required','date_format:H:i','after:hora_inicio'],
            'ubicacion' => ['required','string'],
            'objetivos' => ['nullable','string'],
            'disciplina' => ['nullable','string'],
        ]);

        $inicio = Carbon::createFromFormat('H:i', $validated['hora_inicio']);
        $fin = Carbon::createFromFormat('H:i', $validated['hora_fin']);
        $duracion = $inicio->diffInMinutes($fin);

        $entrenamiento->update([
            'disciplina' => strtolower($validated['disciplina'] ?? $entrenamiento->disciplina),
            'categoria' => strtolower($validated['categoria']),
            'tipo' => strtolower($validated['tipo']),
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora_inicio'],
            'duracion' => $duracion,
            'ubicacion' => strtolower($validated['ubicacion']),
            'objetivos' => $validated['objetivos'] ?? $entrenamiento->objetivos,
        ]);

        return redirect(url('coach/dashboard#gestion-entrenamientos'))
            ->with('success', 'Entrenamiento actualizado correctamente.');
    }

    /**
     * Eliminar un entrenamiento del coach autenticado.
     */
    public function destroyFromCoach($id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);
        if ($entrenamiento->entrenador_id !== Auth::id()) {
            abort(403);
        }

        $entrenamiento->delete();
        return back()->with('success', 'Entrenamiento eliminado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

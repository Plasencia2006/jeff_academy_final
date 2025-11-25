<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnuncioController extends Controller
{
    /**
     * Mostrar la vista de avisos del coach con todos los anuncios
     */
    public function index()
    {
        $anuncios = Anuncio::where('coach_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.coach.avisos', compact('anuncios'));
    }

    /**
     * Almacenar un nuevo anuncio
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'categoria' => 'nullable|string',
            'audiencia' => 'required|in:todos,categoria',
            'enlace' => 'nullable|url',
            'vigente_hasta' => 'nullable|date|after_or_equal:today',
            'prioridad' => 'required|in:normal,importante,urgente'
        ], [
            'titulo.required' => 'El título es obligatorio',
            'mensaje.required' => 'El mensaje es obligatorio',
            'audiencia.required' => 'Debes seleccionar una audiencia',
            'enlace.url' => 'El enlace debe ser una URL válida',
            'vigente_hasta.after_or_equal' => 'La fecha de vigencia debe ser igual o posterior a hoy'
        ]);

        // Agregar el coach_id del usuario autenticado
        $validated['coach_id'] = Auth::id();
        $validated['activo'] = true;

        try {
            Anuncio::create($validated);
            return redirect()->back()->with('success', '✅ Anuncio publicado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Error al publicar el anuncio: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar un anuncio existente
     */
    public function update(Request $request, $id)
    {
        $anuncio = Anuncio::where('coach_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'categoria' => 'nullable|string',
            'audiencia' => 'required|in:todos,categoria',
            'enlace' => 'nullable|url',
            'vigente_hasta' => 'nullable|date|after_or_equal:today',
            'prioridad' => 'required|in:normal,importante,urgente',
            'activo' => 'sometimes|boolean'
        ]);

        try {
            $anuncio->update($validated);
            return redirect()->back()->with('success', '✅ Anuncio actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Error al actualizar el anuncio: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un anuncio
     */
    public function destroy($id)
    {
        $anuncio = Anuncio::where('coach_id', Auth::id())->findOrFail($id);
        
        try {
            $anuncio->delete();
            return redirect()->back()->with('success', '✅ Anuncio eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Error al eliminar el anuncio: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar el estado activo/inactivo de un anuncio
     */
    public function toggleActivo($id)
    {
        $anuncio = Anuncio::where('coach_id', Auth::id())->findOrFail($id);
        $anuncio->activo = !$anuncio->activo;
        $anuncio->save();

        $estado = $anuncio->activo ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "✅ Anuncio {$estado} correctamente");
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Comunicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComunicadoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'tipo' => 'required|in:admin_to_coach,coach_to_admin',
            'destinatario_id' => 'nullable|exists:users,id',
        ]);

        $destinatarioId = $request->destinatario_id;
        
        // Si es un mensaje de coach a admin, buscar el primer admin
        if ($request->tipo === 'coach_to_admin' && !$destinatarioId) {
            $admin = \App\Models\User::where('role', 'admin')->first();
            $destinatarioId = $admin ? $admin->id : null;
        }

        Comunicado::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'remitente_id' => Auth::id(),
            'destinatario_id' => $destinatarioId,
            'tipo' => $request->tipo,
            'leido' => false,
        ]);

        return back()->with('success', 'Comunicado enviado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $comunicado = Comunicado::findOrFail($id);
        
        // Verificar permisos (solo el remitente puede editar)
        if ($comunicado->remitente_id !== Auth::id()) {
            return back()->with('error', 'No tienes permiso para editar este comunicado.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'destinatario_id' => 'nullable|exists:users,id',
        ]);

        $comunicado->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'destinatario_id' => $request->destinatario_id,
        ]);

        return back()->with('success', 'Comunicado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $comunicado = Comunicado::findOrFail($id);
        
        // Verificar permisos (solo el remitente o admin puede borrar)
        if (Auth::user()->role !== 'admin' && $comunicado->remitente_id !== Auth::id()) {
            return back()->with('error', 'No tienes permiso para eliminar este comunicado.');
        }

        $comunicado->delete();

        return back()->with('success', 'Comunicado eliminado correctamente.');
    }
}

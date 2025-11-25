<?php

namespace App\Http\Controllers;

use App\Models\Comunicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoachController extends Controller
{
    /**
     * Muestra la vista del perfil del coach con comunicados
     */
    public function perfil()
    {
        $coach = Auth::user();
        
        // CARGAR COMUNICADOS DESDE LA BASE DE DATOS
        // Obtener comunicados donde el coach es remitente o destinatario
        $comunicados = Comunicado::where(function($query) {
                $query->where('remitente_id', Auth::id())
                      ->orWhere('destinatario_id', Auth::id());
            })
            ->with(['remitente', 'destinatario']) // Cargar las relaciones
            ->orderBy('created_at', 'desc') // Más recientes primero
            ->get();
        
        return view('dashboard.coach.perfil', compact('coach', 'comunicados'));
    }

    /**
     * Actualiza el perfil del coach (incluye enlaces)
     */
    public function update(Request $request)
    {
        $request->validate([
            // Información personal
            'name' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'direccion' => 'nullable|string|max:255',
            'biografia' => 'nullable|string|max:1000',
            
            // Enlaces profesionales
            'enlaces' => 'nullable|array',
            'enlaces.*.nombre' => 'nullable|string|max:100',
            'enlaces.*.url' => 'nullable|url|max:255',
            
            // Información profesional (coaches)
            'especialidad' => 'nullable|string|max:100',
            'anos_experiencia' => 'nullable|integer|min:0|max:50',
            
            // Foto
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Filtrar enlaces vacíos
        $enlaces = collect($request->enlaces ?? [])
            ->filter(function ($enlace) {
                return !empty($enlace['nombre']) && !empty($enlace['url']);
            })
            ->values()
            ->toArray();

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

        // Actualizar datos
        $user->update([
            'name' => $request->name,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion' => $request->direccion,
            'especialidad' => $request->especialidad,
            'anos_experiencia' => $request->anos_experiencia,
            'biografia' => $request->biografia,
            'enlaces' => $enlaces,
        ]);

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Actualiza solo la imagen de perfil (AJAX)
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Eliminar imagen anterior
        if ($user->foto_perfil && Storage::exists('public/' . $user->foto_perfil)) {
            Storage::delete('public/' . $user->foto_perfil);
        }

        // Guardar nueva imagen
        $path = $request->file('foto_perfil')->store('profiles', 'public');
        $user->update(['foto_perfil' => $path]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Imagen actualizada correctamente',
            'foto_url' => Storage::url($path)
        ]);
    }
}

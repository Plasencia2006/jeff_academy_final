<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Disciplina;
use App\Models\PlanSubscription;
use App\Models\Inscripcion;
use App\Models\Registro;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirigir según el rol
        $role = auth()->user()->role;
        return match($role) {
            'admin' => redirect('/admin/dashboard'),
            'coach' => redirect('/coach/dashboard'),
            'player' => redirect('/player/dashboard'),
            default => redirect('/')
        };
    }

    public function getDashboardStats()
    {
        try {
            // Total de usuarios (de la tabla users)
            $totalUsuarios = User::count();
            
            // Usuarios activos vs inactivos (usando el campo 'activo')
            $usuariosActivos = User::where('activo', true)->count();
            $usuariosInactivos = User::where('activo', false)->count();
            
            // Porcentajes
            $porcentajeActivos = $totalUsuarios > 0 ? round(($usuariosActivos / $totalUsuarios) * 100, 2) : 0;
            $porcentajeInactivos = $totalUsuarios > 0 ? round(($usuariosInactivos / $totalUsuarios) * 100, 2) : 0;
            
            // Distribución por tipo de usuario (role)
            $distribucionUsuarios = User::select('role', DB::raw('COUNT(*) as total'))
                ->groupBy('role')
                ->get()
                ->pluck('total', 'role');
            
            // Distribución de planes (usando suscripciones activas)
            $distribucionPlanes = PlanSubscription::where('status', 'active')
                ->where('end_date', '>', now())
                ->select('plan_id', DB::raw('COUNT(*) as total'))
                ->with('plan:id,nombre')
                ->groupBy('plan_id')
                ->get()
                ->mapWithKeys(function($item) {
                    return [$item->plan->nombre ?? 'Plan no encontrado' => $item->total];
                }) ?? collect(); // Usar colección vacía si no hay datos
            
            // Distribución de disciplinas (usando inscripciones)
            $distribucionDisciplinas = Inscripcion::select('disciplina', DB::raw('COUNT(*) as total'))
                ->groupBy('disciplina')
                ->get()
                ->pluck('total', 'disciplina') ?? collect();

            return response()->json([
                'totalUsuarios' => $totalUsuarios,
                'usuariosActivos' => $usuariosActivos,
                'usuariosInactivos' => $usuariosInactivos,
                'porcentajeActivos' => $porcentajeActivos,
                'porcentajeInactivos' => $porcentajeInactivos,
                'distribucionUsuarios' => $distribucionUsuarios,
                'distribucionPlanes' => $distribucionPlanes,
                'distribucionDisciplinas' => $distribucionDisciplinas
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
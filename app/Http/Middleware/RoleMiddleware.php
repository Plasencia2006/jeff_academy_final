<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            return redirect('/login');
        }

        // Normalizar roles
        $roles = array_map(fn($r) => strtolower(trim($r)), $roles);
        $userRole = strtolower((string) ($request->user()->role ?? ''));

        // Si no se pasaron roles en la ruta, permitir el acceso
        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el rol del usuario está en los roles permitidos
        if (in_array($userRole, $roles, true)) {
            return $next($request);
        }

        // Si no tiene el rol, redirigir a la página principal
        return redirect('/')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
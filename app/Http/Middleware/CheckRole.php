<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        // Log::info('Usuario autenticado en middleware:', [
        //     'id' => $user->id_usuario,
        //     'nombre' => $user->nombre,
        //     'rol' => $user->rol->tipo_rol]);
        if (!$user || $user->rol->tipo_rol !== $role) {
            Log::info('Usuario no autenticado en middleware se aborta el acceso');
            abort(403, 'No tienes permiso para acceder a esta ruta.');
        }

        return $next($request);
    }
}

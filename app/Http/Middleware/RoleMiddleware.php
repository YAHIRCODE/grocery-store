<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // 1. Verificamos si el usuario inició sesión
        if (!Auth::check()) {
            return redirect('login');
        }
$user = Auth::user();

        // 2. Obtenemos el rol del usuario (asumiendo que usas la columna 'role' en tu tabla users)
        // $userRole = Auth::user()->role;

    // 3. Si el rol del usuario está en la lista de roles permitidos, lo dejamos pasar
if ($user) {
        foreach ($roles as $role) {
            // Aquí ya DEBE reconocer el método que tienes en el modelo
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }
    }

        // 4. Si no tiene permiso, lo mandamos afuera con un error 403
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}

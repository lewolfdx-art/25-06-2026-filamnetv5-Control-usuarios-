<?php
// app/Http/Middleware/CheckUserActive.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Si el usuario está inactivo
            if (!Auth::user()->is_active) {
                // Cerrar sesión
                Auth::logout();
                
                // Redirigir al login con mensaje de error
                return redirect()->route('filament.admin.auth.login')
                    ->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
            }
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Este middleware redirecciona al usuario a la página de inicio de sesión si no está autenticado. 
     * La redirección se realiza a través de la ruta especificada en redirectTo. Si la solicitud es una solicitud AJAX, no se realiza la redirección.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}

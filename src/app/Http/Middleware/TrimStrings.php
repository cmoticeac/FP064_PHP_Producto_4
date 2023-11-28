<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * Antes de validar los datos de la solicitud, este middleware recorta los espacios en blanco de las cadenas de texto. 
     * Sin embargo, hay ciertas cadenas (enumeradas en $except) que no serán recortadas.
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}

<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Durante el modo de mantenimiento, este middleware permite definir ciertas URIs que deben seguir siendo accesibles. 
     * Especifica las URIs que pueden ser alcanzadas incluso cuando el sitio está en modo de mantenimiento.
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}

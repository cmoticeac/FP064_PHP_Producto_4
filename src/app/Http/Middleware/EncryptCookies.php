<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Este middleware permite especificar cookies que no deben ser cifradas. 
     * Las cookies enumeradas en la propiedad $except no se cifrarán.
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}

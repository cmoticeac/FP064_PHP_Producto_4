<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * 
     * Este middleware protege contra ataques CSRF (Cross-Site Request Forgery). 
     * Enumera las URIs que están exentas de la verificación CSRF.
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}

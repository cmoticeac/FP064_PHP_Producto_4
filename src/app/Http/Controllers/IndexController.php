<?php

namespace App\Http\Controllers;

use App\Models\Acto;
use App\Models\TipoActo;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // Comprobar si el usuario está autenticado
        if (Auth::check()) {
            // redirigimos a dashboard
            return redirect()->route('dashboard');
        } else {
            // Redirigir a la vista de registro o inicio de sesión
            return view('index.register');
        }
    }
    
}
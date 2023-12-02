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
            // Obtener los actos y los tipos de actos
            $actos = Acto::all();
            $tiposActo = TipoActo::all();

            // Redirigir a la vista del dashboard
            return view('index.dashboard', [
                'user' => Auth::user(),
                'actos' => $actos,
                'tipos_acto' => $tiposActo,
            ]);
        } else {
            // Redirigir a la vista de registro o inicio de sesión
            return view('index.register');
        }
    }
    
}
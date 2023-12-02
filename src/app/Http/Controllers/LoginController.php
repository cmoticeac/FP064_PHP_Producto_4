<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use App\Models\TiposUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class LoginController extends Controller
{
    
    // Método para mostrar el formulario de registro
    public function registerPost(Request $request)
    {
        // Comprobar si el usuario está autenticado
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Redirecciona si el usuario ya está logueado
        }

        // Comprobar si se ha enviado el formulario
        $validatedData = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellido1' => 'required|string|max:255',
            'Apellido2' => 'required|string|max:255',
            'Username' => 'required|string|max:255',
            'Password' => 'required|string|min:6',
        ]);

        // comprobar si existe el usuario por el Username
        if (Usuario::where('Username', $validatedData['Username'])->exists()) {
            return Redirect::back()->with('danger', 'El nombre de usuario ya existe.');
        }

        // Crear Persona
        $persona = Persona::create([
            'Nombre' => $validatedData['Nombre'],
            'Apellido1' => $validatedData['Apellido1'],
            'Apellido2' => $validatedData['Apellido2'],
        ]);

        // Crear Usuario
        $usuario = Usuario::create([
            'Username' => $validatedData['Username'],
            'Password' => Hash::make($validatedData['Password']),
            'Id_Persona' => $persona->Id_persona,
            'Id_tipo_usuario' => TiposUsuario::DEFAULT_TIPO_USUARIO
        ]);

        // Loguear al usuario
        Auth::login($usuario);

        return redirect()->route('dashboard')->with('success', 'Se ha registrado correctamente.');
    }

    // Método para mostrar el formulario de inicio de sesión (Logueamos)
    public function loginPost(Request $request)
    {
        $request->validate([
            'Username' => 'required|string',
            'Password' => 'required|string',
        ]);

        // Comprobar si el usuario existe y la contraseña es correcta
        $user = Usuario::login($request->Username, $request->Password);
        // autenticar al usuario
        if ($user) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Se ha logueado correctamente.');
        }

        return Redirect::back()->with('danger', 'Error al loguear el usuario.');
    }
    
}
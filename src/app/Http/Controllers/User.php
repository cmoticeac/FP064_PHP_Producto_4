<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    // Middleware para comprobar si el usuario está autenticado
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para mostrar el perfil del usuario
    public function edit()
    {
        return view('user.edit', ['user' => Auth::user()]);
    }

    // Método para actualizar los datos del usuario
    public function save(Request $request)
    {
        $request->validate([
            'Username' => 'required|string|max:255',
            'Nombre' => 'required|string|max:255',
            'Apellido1' => 'required|string|max:255',
            'Apellido2' => 'required|string|max:255',
        ]);

        // Actualiza la información del usuario
        $user = Usuario::find(Auth::id());
        $user->username = $request->Username;
        if ($request->filled('Password')) {
            $user->password = Hash::make($request->Password);
        }
        // guardarmos los cambios
        $user->save();

        // Actualiza la información de la persona
        $persona = Persona::find($user->persona_id);
        $persona->update($request->only(['Nombre', 'Apellido1', 'Apellido2']));

        return Redirect::back()->with('success', 'Se ha actualizado correctamente.');
    }

    // Método para mostrar el formulario de registro
    public function register(Request $request)
    {
        // Comprobar si el usuario está autenticado
        if (Auth::check()) {
            return redirect()->route('home'); // Redirecciona si el usuario ya está logueado
        }

        // Comprobar si se ha enviado el formulario
        $validatedData = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellido1' => 'required|string|max:255',
            'Apellido2' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:usuarios',
            'Password' => 'required|string|min:6',
        ]);

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
            'persona_id' => $persona->id,
            // 'tipo_usuario_id' => TiposUsuarios::DEFAULT_TIPO_USUARIO
        ]);

        // Loguear al usuario
        Auth::login($usuario);

        return redirect()->route('dashboard')->with('success', 'Se ha registrado correctamente.');
    }

    // Método para mostrar el formulario de inicio de sesión (Logueamos)
    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required|string',
            'Password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('Username', 'Password'))) {
            return Redirect::to(route('dashboard'))->with('success', 'Se ha logueado correctamente.');
        }

        return Redirect::back()->with('danger', 'Error al loguear el usuario.');
    }

    // Método para cerrar sesión
    public function logout()
    {
        Auth::logout();
        return Redirect::to(route('home'))->with('success', 'Ha cerrado sesión correctamente.');
    }
}

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

}

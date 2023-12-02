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
    public function userEdit()
    {
        // recuperamos el usuario y persona
        $usuario = Usuario::find(Auth::id());
        $persona = Persona::find($usuario->Id_Persona);
        // construimos el array de datos de editar usuario
        $userForm = [];
        $userForm['Username'] = $usuario->Username;
        $userForm['Id_tipo_usuario'] = $usuario->Id_tipo_usuario;
        $userForm['Nombre'] = $persona->Nombre;
        $userForm['Apellido1'] = $persona->Apellido1;
        $userForm['Apellido2'] = $persona->Apellido2;

        return view('user.edit', ['user' => (object)$userForm]);
    }

    // Método para actualizar los datos del usuario
    public function userSave(Request $request)
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
        $persona = Persona::find($user->Id_Persona);
        $persona->update($request->only(['Nombre', 'Apellido1', 'Apellido2']));

        return Redirect::back()->with('success', 'Se ha actualizado correctamente.');
    }

}

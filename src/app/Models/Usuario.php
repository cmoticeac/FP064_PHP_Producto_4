<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model //Se ha cambiado el nombre de la clase a Usuario, siguiendo la convención de Laravel.
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'Id_usuario';
    public $timestamps = false; // Añade esto solo si tu tabla no tiene campos timestamps

    // Método para registrar un nuevo usuario
    public static function register(string $username, string $password, int $idPersona, int $tipoUsuario)
    {
        // Cifrar la contraseña
        $hashedPassword = Hash::make($password);
        
        // Crear y guardar el nuevo usuario
        return self::create([
            'Username' => $username,
            'Password' => $hashedPassword,
            'Id_Persona' => $idPersona,
            'Id_tipo_usuario' => $tipoUsuario
        ]);
    }

    // Método para verificar las credenciales de un usuario
    public static function login($username, $password)
    {
        // Buscar al usuario por su nombre de usuario
        $user = self::where('Username', $username)->first();
        
        // Verificar si el usuario existe y la contraseña es correcta
        if ($user && Hash::check($password, $user->Password)) {
            return $user;
        }

        return false;
    }

    // Método para actualizar los datos de un usuario
    public function updateProfile($username, $password, $idPersona, $tipoUsuario)
    {
        // Cifrar la nueva contraseña
        $hashedPassword = Hash::make($password);

        // Actualizar el usuario
        $this->Username = $username;
        $this->Password = $hashedPassword;
        $this->Id_Persona = $idPersona;
        $this->Id_tipo_usuario = $tipoUsuario;
        return $this->save();
    }

    // Método para verificar si un nombre de usuario ya existe
    public static function existeUsername(string $username): bool
    {
        return self::where('Username', $username)->exists();
    }
}

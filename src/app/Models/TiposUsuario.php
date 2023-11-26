<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposUsuario extends Model // Cambiado el nombre a TiposUsuario, siguiendo la convención de Laravel de usar nombres de modelo en singular.
{
    const DEFAULT_TIPO_USUARIO = 3; // Usuario

    protected $table = 'Tipos_usuarios';
    protected $primaryKey = 'Id_tipo_usuario';
    public $timestamps = false; // Si nuestra tabla no tiene campos timestamps


}

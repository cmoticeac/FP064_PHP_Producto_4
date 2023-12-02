<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'Personas';
    protected $primaryKey = 'Id_persona';
    protected $fillable = ['Nombre', 'Apellido1', 'Apellido2'];
    public $timestamps = false; // Si nuestra tabla no tiene campos timestamps

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoActo extends Model
{
    protected $table = 'Tipo_acto';
    protected $primaryKey = 'Id_tipo_acto';
    public $timestamps = false; // Ni nustra tabla no tiene campos timestamps

}

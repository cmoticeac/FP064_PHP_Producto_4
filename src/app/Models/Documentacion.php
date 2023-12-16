<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{
    protected $table = 'Documentacion';
    protected $primaryKey = 'Id_presentacion';
    protected $fillable = ['Id_acto', 'Id_persona', 'Titulo_documento', 'Localizacion_documentacion', 'Orden'];
    public $timestamps = false;

}

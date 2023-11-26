<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Acto extends Model
{
    protected $table = 'Actos';
    protected $primaryKey = 'Id_acto';

    public function inscritos(): BelongsToMany
    {
        // Asumiendo que hay una relación muchos a muchos entre Actos e Inscritos
        return $this->belongsToMany(Persona::class, 'Inscritos', 'Id_acto', 'Id_persona');
    }

    public function ponentes(): HasMany
    {
        // Asumiendo una relación uno a muchos entre Actos y Lista_Ponentes
        return $this->hasMany(ListaPonentes::class, 'Id_acto');
    }

    public function tipoActo()
    {
        // Asumiendo una relación uno a uno entre Actos y Tipo_acto
        return $this->hasOne(TipoActo::class, 'Id_tipo_acto', 'Id_tipo_acto');
    }

    public function allWithInscripcion($idPersona)
    {
        // Utilizar Eloquent para realizar la consulta
        return Acto::with(['inscritos' => function($query) use ($idPersona) {
            $query->where('Id_persona', $idPersona);
        }, 'ponentes' => function($query) use ($idPersona) {
            $query->where('Id_persona', $idPersona);
        }, 'tipoActo'])
        ->get();
    }

    public function allAdmin()
    {
        // Utilizar Eloquent para realizar la consulta
        return Acto::with('tipoActo')->get();
    }

    public function deleteActo($idActo)
    {
        $acto = Acto::find($idActo);

        if ($acto->ponentes()->count() > 0 || $acto->inscritos()->count() > 0) {
            return false; // No se puede eliminar si hay ponentes o inscritos
        }

        return $acto->delete();
    }

    private function hasPonentes($idActo)
    {
        // Encuentra el acto por su ID y cuenta los ponentes asociados
        $acto = Acto::find($idActo);
        return ($acto && $acto->ponentes()->count() > 0);
    }

    private function hasInscritos($idActo)
    {
        // Encuentra el acto por su ID y cuenta los inscritos asociados
        $acto = Acto::find($idActo);
        return ($acto && $acto->inscritos()->count() > 0);
    }
}
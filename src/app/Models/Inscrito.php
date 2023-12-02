<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscrito extends Model
{
    protected $table = 'Inscritos';
    protected $primaryKey = 'Id_inscripcion';
    protected $fillable = ['Id_acto', 'Id_persona', 'Fecha_inscripcion'];
    public $timestamps = false; // Si nuestra tabla no tiene campos timestamps

    public function acto()
    {
        return $this->belongsTo(Acto::class, 'Id_acto');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona');
    }

    public static function existeInscripcion($idActo, $idPersona)
    {
        return self::where('Id_acto', $idActo)
                   ->where('Id_persona', $idPersona)
                   ->exists();
    }

    public static function createInscripcion($idActo, $idPersona)
    {
        if (!self::existeInscripcion($idActo, $idPersona)) {
            return self::create([
                'Id_acto' => $idActo,
                'Id_persona' => $idPersona,
                'Fecha_inscripcion' => now()
            ]);
        }

        return false;
    }

    public static function getNumInscritos($idActo)
    {
        return self::where('Id_acto', $idActo)->count();
    }

    public static function getInscritos($idActo = null)
    {
        $query = self::with(['persona', 'acto']);

        if (is_numeric($idActo)) {
            $query->where('Id_acto', $idActo);
        }

        return $query->get();
    }
}

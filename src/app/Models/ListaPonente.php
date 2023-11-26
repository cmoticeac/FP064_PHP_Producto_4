<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaPonente extends Model
{
    protected $table = 'Lista_Ponentes';
    protected $primaryKey = 'id_ponente';
    public $timestamps = false; // Si nuestra tabla no tiene campos timestamps

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Id_persona');
    }

    public function acto()
    {
        return $this->belongsTo(Acto::class, 'Id_acto');
    }

    public static function getPonentes($idActo = null)
    {
        $query = self::with(['persona', 'acto']);

        if (is_numeric($idActo)) {
            $query->where('Id_acto', $idActo);
        }

        return $query->get();
    }
}

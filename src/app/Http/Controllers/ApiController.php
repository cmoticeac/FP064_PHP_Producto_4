<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Acto;
use Illuminate\Support\Facades\URL;

class ApiController extends Controller
{
    public function eventosFuturos()
    {
        $fechaActual = date('Y-m-d');
        $eventos = Acto::with(['tipoActo'])
            ->where('Fecha', '>=', $fechaActual)
            ->orderBy('Fecha', 'asc')
            ->get();

        // Añadir URL a cada evento
        $eventos->map(function ($evento) {
            $evento->url = URL::to('/') . '/eventos/' . $evento->Id_acto;
            return $evento;
        });

        return response()->json($eventos);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Acto;
use App\Models\Inscrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    // Middleware para comprobar si el usuario está autenticado
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para mostrar el calendario
    public function index()
    {
        $idPersona = Auth::id();
        $actos = Acto::with(['inscritos', 'ponentes', 'tipoActo'])->get();
        $eventos = $this->crearEventos($actos, $idPersona);

        return view('calendario.index', ['eventos' => json_encode($eventos)]);
    }
    // Método para realizar la inscripción a un acto
    public function inscripcion($idActo)
    {
        $idPersona = Auth::id();
        $acto = Acto::findOrFail($idActo);

        if ($acto->inscritos->count() < $acto->Num_asistentes && !$acto->inscritos->contains('Id_persona', $idPersona)) {
            Inscrito::create(['Id_acto' => $idActo, 'Id_persona' => $idPersona]);
            return redirect()->route('calendario.index')->with('success', 'Inscripción realizada correctamente.');
        }

        return redirect()->route('calendario.index')->with('danger', 'No hay plazas disponibles o ya estás inscrito.');
    }

    // Método para realizar la desinscripción de un acto
    public function desuscripcion($idActo)
    {
        $idPersona = Auth::id();
        $inscrito = Inscrito::where('Id_acto', $idActo)->where('Id_persona', $idPersona)->first();

        if ($inscrito) {
            $inscrito->delete();
            return redirect()->route('calendario.index')->with('success', 'Desinscripción realizada correctamente.');
        }

        return redirect()->route('calendario.index')->with('danger', 'Error al realizar la desinscripción.');
    }

    // Método para crear los eventos del calendario
    private function crearEventos($actos, $idPersona)
    {
        $eventos = [];
        $evento = null;

        foreach ($actos as $acto) {
            $esPonente = $acto->ponentes->contains('Id_persona', $idPersona);
            $esInscrito = $acto->inscritos->contains('Id_persona', $idPersona);
            
            $evento = [
                'id' => $acto->Id_acto,
                'title' => $acto->Titulo,
                'start' => $acto->Fecha,
                'end' => $acto->Fecha,
                'color' => $esPonente ? '#007bff' : ($esInscrito ? '#28a745' : '#dc3545'),
                'textColor' => '#fff',
                'url' => route('calendario.inscripcion', $acto->Id_acto),
                'classNames' => $esPonente ? 'ponencia' : ($esInscrito ? 'inscrito' : 'no-inscrito'),
            ];

            $eventos[] = $evento;
        }
        return $eventos;
    }
}

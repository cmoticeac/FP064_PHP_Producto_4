<?php

namespace App\Http\Controllers;

use App\Models\Acto;
use App\Models\Usuario;
use App\Models\Persona;
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
        $usuario = Usuario::find(Auth::id());
        $persona = Persona::find($usuario->Id_Persona);
        // construimos el array de datos de editar usuario
        $userForm = [];
        $userForm['Username'] = $usuario->Username;
        $userForm['Id_tipo_usuario'] = $usuario->Id_tipo_usuario;
        $userForm['Nombre'] = $persona->Nombre;
        $userForm['Apellido1'] = $persona->Apellido1;
        $userForm['Apellido2'] = $persona->Apellido2;

        $actos = Acto::with(['inscritos', 'ponentes', 'tipoActo'])->get();
        $eventos = $this->crearEventos($actos, $usuario->Id_Persona);

        return view('index.calendario', [
            'user' => (object)$userForm,
            'eventos' => json_encode($eventos)
        ]);
    }
    // Método para realizar la inscripción a un acto
    public function inscripcion($idActo)
    {
        $usuario = Usuario::find(Auth::id());
        $acto = Acto::findOrFail($idActo);

        if ($acto->inscritos->count() < $acto->Num_asistentes && !$acto->inscritos->contains('Id_persona', $usuario->Id_Persona)) {
            Inscrito::create(['Id_acto' => $idActo, 'Id_persona' => $usuario->Id_Persona, 'Fecha_inscripcion' => now()]);
            return redirect()->route('calendario')->with('success', 'Inscripción realizada correctamente.');
        }

        return redirect()->route('calendario')->with('danger', 'No hay plazas disponibles o ya estás inscrito.');
    }

    // Método para realizar la desinscripción de un acto
    public function desuscripcion($idActo)
    {
        $usuario = Usuario::find(Auth::id());
        $inscrito = Inscrito::where('Id_acto', $idActo)->where('Id_persona', $usuario->Id_Persona)->first();

        if ($inscrito) {
            $inscrito->delete();
            return redirect()->route('calendario')->with('success', 'Desinscripción realizada correctamente.');
        }

        return redirect()->route('calendario')->with('danger', 'Error al realizar la desinscripción.');
    }

    // Método para crear los eventos del calendario
    private function crearEventos($actos, $idPersona)
    {
        $eventos = [];
        $evento = null;

        foreach ($actos as $acto) {
            $esPonente = $acto->ponentes->contains('Id_persona', $idPersona);
            $esInscrito = $acto->inscritos->contains('Id_persona', $idPersona);

            $description = "
                <div><strong>Título:</strong> {$acto->Titulo}</div>
                <div><strong>Fecha/Hora:</strong> {$acto->Fecha} {$acto->Hora}</div>
                <div><strong>Descripción corta:</strong> {$acto->Descripcion_corta}</div>
                <div><strong>Descripción larga:</strong> {$acto->Descripcion_larga}</div>
                <div><strong>Aforo:</strong> {$acto->Num_asistentes}</div>
                <div><strong>Tipo de acto:</strong> {$acto->Id_tipo_acto}</div><br>
                ";
            
            $evento = [
                'id' => $acto->Id_acto,
                'title' => $acto->Titulo,
                'start' => $acto->Fecha,
                'end' => $acto->Fecha,
                'color' => $esPonente ? '#ff8000' : ($esInscrito ? '#28a745' : '#dc3545'),
                'textColor' => '#fff',
                'url' => $esPonente ? '' : (($esInscrito ? route('desuscripcion', ['id' => $acto->Id_acto]) : route('inscripcion', ['id' => $acto->Id_acto]))),
                'classNames' => $esPonente ? 'ponencia' : ($esInscrito ? 'inscrito' : 'no-inscrito'),
                'description' => $description,
                'description2' => $esPonente ? 'ERES PONENTE' : ($esInscrito ? 'Clic para desuscribirte' : 'Clic para suscribirte'),
            ];

            $eventos[] = $evento;
        }
        return $eventos;
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Acto;
use App\Models\Documentacion;

class EventosController extends Controller
{
    // Método para mostrar el calendario
    public function index()
    {

        $actos = Acto::with(['ponentes', 'tipoActo'])->get();
        $eventos = $this->crearEventos($actos);

        return view('eventos.index', [
            'eventos' => json_encode($eventos)
        ]);
    }

    public function eventoView($id)
    {
        $acto = Acto::with(['tipoActo', 'ponentes'])->find($id);

        // recuperar los documentos de la ponencia
        $documentos = Documentacion::where('Id_acto', $id)->orderBy('Orden')->get();

        // variable booleana que define si el usuario esta auténticado o no
        $autenticado = auth()->check();

        $user = auth()->user();
        
        return view('eventos.view', [
            'acto' => $acto,
            'documentos' => $documentos,
            'autenticado' => $autenticado,
            'user' => $user,
        ]);
    }

    // Método para crear los eventos del calendario
    private function crearEventos($actos)
    {
        $eventos = [];
        $evento = null;

        foreach ($actos as $acto) {
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
                'color' => '#1111ee',
                'textColor' => '#fff',
                'url' => route('eventos', ['id' => $acto->Id_acto]),
                'classNames' => 'no-inscrito',
                'description' => $description,
            ];

            $eventos[] = $evento;
        }
        return $eventos;
    }

    public function invitacion()
    {
        return redirect()->route('index')->with('error', 'Por favor, inicie sesión o registrese para poder inscribirse.');
    }
}
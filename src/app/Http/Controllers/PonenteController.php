<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Acto;
use App\Models\Documentacion;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PonenteController extends Controller
{
    // Suponiendo que ya tienes middleware para verificar si es admin
    public function __construct()
    {
        $this->middleware('auth');

    }

    // Método para mostrar la lista de ponencias del ponente
    public function misponenciasList()
    {
        // validar que es ponente
        $usuario = Usuario::find(Auth::id());
        if (!in_array($usuario->Id_tipo_usuario,[1,2])) {
            return redirect()->route('index')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        $persona = Persona::find($usuario->Id_Persona);
        // construimos el array de datos de editar usuario
        $userForm = [];
        $userForm['Username'] = $usuario->Username;
        $userForm['Id_tipo_usuario'] = $usuario->Id_tipo_usuario;
        $userForm['Nombre'] = $persona->Nombre;
        $userForm['Apellido1'] = $persona->Apellido1;
        $userForm['Apellido2'] = $persona->Apellido2;

        $actos = Acto::with(['tipoActo', 'ponentes'])->get();

        // añadir atributo a actos para saber si se puede subir documentación
        foreach ($actos as $acto) {
            $acto->puedeSubirDocumentacion = false;
            if($acto->Fecha < date('Y-m-d') || ($acto->Fecha == date('Y-m-d') && $acto->Hora < date('H:i:s'))) {
                $acto->puedeSubirDocumentacion = true;
            }
        }

        return view('misponencias.index', [
            'user' => (object)$userForm,
            'actos' => $actos
        ]);
    }

    // Método para gestionar los documentos de una ponencia
    public function misponenciasDocs($id)
    {
        // validar que es ponente
        $usuario = Usuario::find(Auth::id());
        if (!in_array($usuario->Id_tipo_usuario,[1,2])) {
            return redirect()->route('index')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        $persona = Persona::find($usuario->Id_Persona);
        // construimos el array de datos de editar usuario
        $userForm = [];
        $userForm['Username'] = $usuario->Username;
        $userForm['Id_tipo_usuario'] = $usuario->Id_tipo_usuario;
        $userForm['Nombre'] = $persona->Nombre;
        $userForm['Apellido1'] = $persona->Apellido1;
        $userForm['Apellido2'] = $persona->Apellido2;
        
        $acto = Acto::with(['tipoActo', 'ponentes'])->find($id);

        // recupera la documentación del acto para la persona ordenada por orden
        $documentos = Documentacion::where('Id_acto', $id)->orderBy('Orden')->get();

        return view('misponencias.docs', [
            'user' => (object)$userForm,
            'documentos' => $documentos,
            'id_acto' => $id
        ]);
    }

    // Método para añadir un documento a una ponencia
    public function misponenciasAddDoc()
    {
        // validar que es ponente
        $usuario = Usuario::find(Auth::id());
        if (!in_array($usuario->Id_tipo_usuario,[1,2])) {
            return redirect()->route('index')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        // validar que el acto es del ponente
        if (in_array($usuario->Id_tipo_usuario,[2])) {
            $acto = Acto::with(['tipoActo', 'ponentes'])->whereHas('ponentes', function ($query) use ($usuario) {
                $query->where('Id_persona', $usuario->Id_Persona);
            })->find(request()->input('id_acto'));
        } else {
            $acto = Acto::with(['tipoActo', 'ponentes'])->find(request()->input('id_acto'));
        }

        // validar que el acto se puede subir documentación
        if(!($acto->Fecha < date('Y-m-d') || ($acto->Fecha == date('Y-m-d') && $acto->Hora < date('H:i:s')))) {
            // si eres administrador
            if (in_array($usuario->Id_tipo_usuario,[1])) {
                return redirect()->route('dashboard')->with('error', 'No puedes subir documentación para este acto porque no ha finalizado.');
            }
            // si eres ponente
            if (in_array($usuario->Id_tipo_usuario,[1])) {
                return redirect()->route('misponencias-list')->with('error', 'No puedes subir documentación para este acto porque no ha finalizado.');
            }
        }

        // validar que se ha subido un fichero
        if (!request()->hasFile('documento')) {
            return redirect()->route('misponencias-docs', ['id' => request()->input('id_acto')])->with('error', 'No se ha subido ningún documento.');
        }

        // guardar archivo en el sistema de ficheros
        $fileName = request()->input('id_acto') . '-' . request()->file('documento')->getClientOriginalName();

        $destinationPath = public_path('uploads');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        request()->file('documento')->move(public_path('uploads'), $fileName);


        // guardar el fichero
        $documento = Documentacion::create([
            'Id_persona' => $usuario->Id_Persona,
            'Id_acto' => request()->input('id_acto'),
            'Titulo_documento' => request()->input('titulo_documento'),
            'Orden' => request()->input('orden_documento') ?? 0,
            'Localizacion_documentacion' => $fileName
        ]);

        return redirect()->route('misponencias-docs', ['id' => request()->input('id_acto')])->with('success', 'Documento subido correctamente.');

    }

    // Método para borrar un documento de una ponencia
    public function misponenciasDeleteDoc($id)
    {
        // validar que es ponente
        $usuario = Usuario::find(Auth::id());
        if (!in_array($usuario->Id_tipo_usuario,[1,2])) {
            return redirect()->route('index')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        // validar que el documento es del ponente
        $documento = Documentacion::find($id);
        if (in_array($usuario->Id_tipo_usuario,[2])) {
            if (!$documento || $documento->Id_persona != $usuario->Id_Persona) {
                return redirect()->route('index')->with('error', 'No eres ponente para el documento.');
            }
        }

        // borrar el documento
        $documento->delete();

        return redirect()->route('misponencias-docs', ['id' => $documento->Id_acto])->with('success', 'Documento borrado correctamente.');
    }

 }
     
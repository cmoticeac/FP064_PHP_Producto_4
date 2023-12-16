<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Acto;
use App\Models\TipoActo;
use App\Models\ListaPonente;
use App\Models\Inscrito;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Suponiendo que ya tienes middleware para verificar si es admin
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para mostrar el dashboard
    public function dashboard()
    {
        // recuperar actos
        $actos = Acto::all();
        $tiposActo = TipoActo::all();

        // añadir label tipo_acto a cada acto
        foreach ($actos as $acto) {
            $acto->tipo_acto = TipoActo::find($acto->Id_tipo_acto)->Descripcion;
        }

        // Redirigir a la vista del dashboard
        return view('index.dashboard', [
            'user' => Auth::user(),
            'actos' => $actos,
            'tipos_acto' => $tiposActo,
        ]);
    }

    // Método para editar un acto existente
    public function actoEdit($id = null)
    {
        $acto = $id ? Acto::find($id) : new Acto;
        $tiposActo = TipoActo::all();
        
        $usuario = Usuario::find(Auth::id());

        return view('actos.edit', [
            'user' => $usuario,
            'acto' => $acto,
            'tipo_acto' => $tiposActo,
        ]);
    }

    // Método para guardar o actualizar un acto
    public function actoSave(Request $request)
    {
        $id = $request->input('Id_acto');
        // Valida y guarda/actualiza el acto
        $acto = Acto::updateOrCreate(
            ['Id_acto' => $id],
            $request->all() // Asegúrate de validar y filtrar los datos adecuadamente
        );

        return redirect()->route('dashboard')
                         ->with('success', $acto ? 'Acto guardado correctamente.' : 'Error al guardar el acto.');
    }

    // Método para eliminar un acto
    public function actoDelete($id)
    {
        try {
            $result = Acto::destroy($id);
            if($result)
                return redirect()->route('dashboard')->with('success', 'Acto eliminado correctamente.');
            else
                return redirect()->route('dashboard')->with('error', 'Error al eliminar el acto.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error al eliminar el acto. Revisa que no tenga Invitados o ponentes asociados.');
        }
    }

    // Método para listar los ponentes de un acto
    public function ponenteList($idActo = null)
    {
        $usuario = Usuario::find(Auth::id());
        if ($idActo) {
            $listaPonentes = ListaPonente::where('Id_acto', $idActo)->get();
        } else {
            $listaPonentes = ListaPonente::all();
        }
        $ponentes = [];
        foreach ($listaPonentes as $ponente) {
            $ponentes[] = (object)[
                'id_ponente' => $ponente->id_ponente,
                'Nombre' => $ponente->persona->Nombre,
                'Apellido1' => $ponente->persona->Apellido1,
                'Apellido2' => $ponente->persona->Apellido2,
                'Titulo' => $ponente->acto->Titulo,
                'Orden' => $ponente->Orden,
            ];
        }
        return view('ponentes.index', [
            'user' => $usuario,
            'ponentes' => (object)$ponentes,
        ]);
    }

    // Método para añadir un ponente a un acto
    public function ponenteAdd($idActo = null)
    {
        $usuario = Usuario::find(Auth::id());
        $actos = Acto::all();
        $personas = Persona::all();
        return view('ponentes.add', [
            'user' => $usuario,
            'actos' => $actos,
            'personas' => $personas,
            'idActo' => $idActo,
        ]);
    }

    // Método para añadir un ponente a un acto
    public function ponenteSave(Request $request)
    {
        $data = $request->validate([
            'Id_acto' => 'required|integer',
            'Id_persona' => 'required|integer',
            'Orden' => 'required|integer'
        ]);

        // comprobar que no existe ya el ponente en el acto
        $ponente = ListaPonente::where('Id_acto', $data['Id_acto'])
                                ->where('Id_persona', $data['Id_persona'])
                                ->first();
        if ($ponente) {
            return redirect()->route('ponente-list')->with('error', 'El ponente ya existe en el acto.');
        }

        ListaPonente::create($data);

        return redirect()->route('ponente-list')->with('success', 'Ponente añadido correctamente.');
    }

    // Método para eliminar un ponente de un acto
    public function ponenteDelete($id)
    {
        $ponente = ListaPonente::find($id);
        if ($ponente) {
            $ponente->delete();
            return redirect()->route('ponente-list')->with('success', 'Ponente eliminado correctamente.');
        }
        return redirect()->route('ponente-list')->with('error', 'Error al eliminar el ponente.');
    }
    // Método para editar/crear un tipo de acto
    public function tipoActoEdit($id = null)
    {
        $tipoActo = $id ? TipoActo::find($id) : new TipoActo;
        $usuario = Usuario::find(Auth::id());

        return view('tipo_acto.edit', [
            'user' => $usuario,
            'tipo_acto' => $tipoActo,
        ]);
    }

    // Método para guardar o actualizar un tipo de acto
    public function tipoActoSave(Request $request)
    {
        $id = $request->input('Id_tipo_acto');
        // Valida y guarda/actualiza el tipo de acto
        $tipoActo = TipoActo::updateOrCreate(
            ['Id_tipo_acto' => $id],
            $request->all() // Asegúrate de validar y filtrar los datos adecuadamente
        );

        return redirect()->route('dashboard')
                         ->with('success', $tipoActo ? 'Tipo de acto guardado correctamente.' : 'Error al guardar el tipo de acto.');
    }

    // Método para eliminar un tipo de acto
    public function tipoActoDelete($id)
    {
        try {
            $result = TipoActo::destroy($id);
            if($result)
                return redirect()->route('dashboard')->with('success', 'Tipo de acto eliminado correctamente.');
            else
                return redirect()->route('dashboard')->with('error', 'Error al eliminar el tipo de acto.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error al eliminar el tipo de acto. Revisa que no tenga actos asociados.');
        }

        return redirect()->route('dashboard')->with('error', 'Error al eliminar el tipo de acto.');
    }

    // Método para listar los inscritos a un acto
    public function inscritosList($idActo = null)
    {
        $usuario = Usuario::find(Auth::id());
        if ($idActo) {
            $inscritosList = Inscrito::where('Id_acto', $idActo)->get();
        } else {
            $inscritosList = Inscrito::all();
        }
        $inscritos = [];
        foreach ($inscritosList as $inscrito) {
            $acto = Acto::find($inscrito->id_acto);
            $inscritos[] = (object)[
                'Id_inscripcion' => $inscrito->Id_inscripcion,
                'Nombre' => $inscrito->persona->Nombre,
                'Apellido1' => $inscrito->persona->Apellido1,
                'Apellido2' => $inscrito->persona->Apellido2,
                'Titulo' => $acto->Titulo,
                'Fecha' => $acto->Fecha,
            ];
        }
        return view('inscritos.index', [
            'user' => $usuario,
            'inscritos' => (object)$inscritos,
        ]);
    }

    // Método para añadir un inscrito a un acto
    public function inscritosAdd($idActo = null)
    {
        $usuario = Usuario::find(Auth::id());
        $actos = Acto::all();
        $personas = Persona::all();
        return view('inscritos.add', [
            'user' => $usuario,
            'actos' => $actos,
            'personas' => $personas,
            'idActo' => $idActo,
        ]);
    }

    // Método para añadir un inscrito a un acto
    public function inscritosSave(Request $request)
    {
        $data = $request->validate([
            'Id_acto' => 'required|integer',
            'Id_persona' => 'required|integer',
        ]);

        // comprobar que no existe ya el inscrito en el acto
        $inscrito = Inscrito::where('Id_acto', $data['Id_acto'])
                                ->where('Id_persona', $data['Id_persona'])
                                ->first();
        if ($inscrito) {
            return redirect()->route('inscritos-list')->with('error', 'El inscrito ya existe en el acto.');
        }

        $data['Fecha_inscripcion'] = date('Y-m-d H:i:s');

        Inscrito::create($data);

        return redirect()->route('inscritos-list')->with('success', 'Inscrito añadido correctamente.');
    }

    // Método para eliminar un inscrito de un acto
    public function inscritosDelete($id)
    {
        $inscrito = Inscrito::find($id);
        if ($inscrito) {
            $inscrito->delete();
            return redirect()->route('inscritos-list')->with('success', 'Inscrito eliminado correctamente.');
        }
        return redirect()->route('inscritos-list')->with('error', 'Error al eliminar el inscrito.');
    }



    // Método para listar los inscritos a un acto
    public function listInscritos($idActo)
    {
        $inscritos = Inscrito::where('Id_acto', $idActo)->get();
        return view('inscritos.index', compact('inscritos'));
    }


    // Método para añadir un inscrito a un acto
    public function addInscrito(Request $request)
    {
        $data = $request->validate([
            'Id_acto' => 'required|exists:actos,id',
            'Id_persona' => 'required|exists:personas,id'
        ]);

        Inscrito::create($data);

        return redirect()->route('inscritos.index')->with('success', 'Inscrito añadido correctamente.');
        }

    // Método para añadir un inscrito a un acto
    public function saveInscrito(Request $request)
    {
        $data = $request->validate([
            'Id_acto' => 'required|exists:actos,id',
            'Id_persona' => 'required|exists:personas,id'
        ]);

        $inscrito = Inscrito::create($data);

        return redirect()->route('inscritos.list', ['id' => $data['Id_acto']])
                        ->with('success', 'Inscrito añadido correctamente.');
    }

    // Método para eliminar un inscrito de un acto
    public function removeInscrito($id)
    {
        $inscrito = Inscrito::find($id);
        if ($inscrito) {
            $actoId = $inscrito->Id_acto;
            $inscrito->delete();
            return redirect()->route('inscritos.list', ['id' => $actoId])
                            ->with('success', 'Inscrito eliminado correctamente.');
        }
        return back()->with('error', 'Error al eliminar el inscrito.');
    }
 }
     
<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Acto;
use App\Models\TipoActo;
use App\Models\ListaPonente;
use App\Models\Inscrito;
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
                return redirect()->route('dashboard')->with('danger', 'Error al eliminar el acto.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('danger', 'Error al eliminar el acto. Revisa que no tenga Invitados o ponentes asociados.');
        }

        return redirect()->route('dashboard')->with('error', 'Error al eliminar el acto.');
    }

        // Método para editar un acto existente
        public function editActo($id)
        {
            $acto = Acto::find($id);
            $tiposActo = TipoActo::all();
    
            return view('actos.edit', compact('acto', 'tiposActo'));
        }
    
        // Método para guardar o actualizar un acto
        public function saveActo(Request $request, $id)
        {
            // Validación y manejo de la solicitud
            $data = $request->validate([
                'Titulo' => 'required|string',
                'Descripcion_corta' => 'required',
                'Fecha' => 'required|date',
               
            ]);
    
            $acto = Acto::updateOrCreate(['Id_acto' => $id], $data);
    
            return redirect()->route('actos.index')->with('status', $acto ? 'Acto guardado correctamente.' : 'Error al guardar el acto.');
        }
    
        // Método para eliminar un acto
        public function deleteActo($id)
        {
            $acto = Acto::find($id);
    
            if ($acto) {
                $acto->delete();
                return redirect()->route('actos.index')->with('success', 'Acto eliminado correctamente.');
            } else {
                return redirect()->route('actos.index')->with('danger', 'Error al eliminar el acto.');
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
        public function savePonente(Request $request)
        {
            $data = $request->validate([
                'Id_acto' => 'required|exists:actos,id',
                'Id_persona' => 'required|exists:personas,id',
                'Orden' => 'required|integer'
            ]);

            ListaPonente::create($data);

            return redirect()->route('ponentes.index')->with('success', 'Ponente añadido correctamente.');
        }

        // Método para eliminar un ponente de un acto
        public function removePonente($id)
        {
            $ponente = ListaPonente::find($id);
            if ($ponente) {
                $ponente->delete();
                return redirect()->route('ponentes.index')->with('success', 'Ponente eliminado correctamente.');
            }
            return redirect()->route('ponentes.index')->with('danger', 'Error al eliminar el ponente.');
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
                return back()->with('danger', 'Error al eliminar el inscrito.');
            }
 }
     
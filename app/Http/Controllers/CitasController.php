<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\User;
use App\Models\Clientes;
use App\Models\Ajustes;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class CitasController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function VerDoctores()
    {
        $doctores = User::orderBy('name','ASC')->where('rol','doctor')->get();

        return view('modulos.citas.Ver-Doctores', compact('doctores'));
    }

    public function CrearDoctores(Request $request)
    {
        $datos = request()->validate([
            'name'=>['string','max:255'],
            'rol'=>['string','max:255'],
            'email'=>['string','unique:users'],
            'password'=>['string','min:3']
        ]);

        User::create([
            'name'=>$datos["name"],
            'email'=>$datos["email"],
            'rol'=>$datos["rol"],
            'password'=>Hash::make($datos["password"]),
            'foto'=>'',
            'estado'=>'Disponible',

        ]);

        return redirect('Doctores')->with('DoctorCreado', 'OK');
    }

    public function CambiarEstado(Request $request,$id_doctor){
        DB::table('users')->where('id',$id_doctor)->update(['estado'=>$request->estado]);

        return redirect('Doctores');
    }
    
    public function index()
    {
        if(auth()->user()->rol == 'doctor'){
            return redirect('Citas-Hoy/'.auth()->user()->id);
        }

        $doctores = User::where('rol','doctor')->get();

        return view('modulos.citas.Citas', compact('doctores'));
    }

    public function Calendario($id_doctor)
    {
        $doctor = User::find($id_doctor);
        $clientes = Clientes::all();

        $citas = Citas::where('id_doctor',$id_doctor)->get();

        return view('modulos.citas.Calendario', compact('doctor','clientes','citas'));
    }

    public function AgendarCita(Request $request)
    {
        $datos = request();

        if ($datos["nota"] == '') {
            $nota = 'Sin Nota';
        }else{
            $nota = $datos["nota"];
        }

        Citas::create([

            'id_doctor'=>$datos["id_doctor"],
            'id_cliente'=>$datos["id_cliente"],
            'inicio'=>$datos["inicio"],
            'fin'=>$datos["fin"],
            'nota'=>$nota,
            'estado'=>'Solicitada',

        ]);

        return redirect('Calendario/'.$datos["id_doctor"])->with('CitaAgendada','OK');
    }

    public function CancelarCita()
    {
        $datos = request();

        $cita = Citas::find($datos["id_cita"]);

        DB::table('citas')->whereId($datos["id_cita"])->delete();

        return redirect('Calendario/'.$cita['id_doctor']);
    }

    public function VerCitasHoy($id_doctor)
    {
        $doctor = User::find($id_doctor);

        $ajustes = Ajustes::find(1);

        date_default_timezone_set($ajustes["zona_horaria"]);

        $fechaHoy = date('Y-m-d');

        $citas = Citas::where('id_doctor',$id_doctor)->where('inicio','LIKE',$fechaHoy.' %')->get();

        return view('modulos.citas.Citas-Hoy', compact('doctor','citas'));
    }

    public function CambiarEstadoCita(Request $request, $id_veterinario)
    {
        $datos = request();

        $Cita = Citas::find($datos["id_cita"]);

        $Cita->estado = $datos["estado"];

        $Cita->save();

        if($datos["estado"] == 'En Proceso'){

            return redirect('Cita/'.$datos["id_cita"]);

        }else{

            return redirect('Citas-Hoy/'.$id_veterinario);
        }
    }

    public function VerCita($id_cita)
    {
        $cita = Citas::find($id_cita);

        $cliente = Clientes::find($cita->id_cliente);
        $doctor = Clientes::find($cita->id_doctor);

        $historial = Historial::where('id_cita',$id_cita)->first();

        return view('modulos.citas.Cita', compact('cita','cliente','doctor','historial'));
    }

    public function FinalizarCita($id_cita)
    {
        Citas::where('id',$id_cita)->update(['estado'=>'Finalizada']);

        return redirect('Cita/'.$id_cita);
    }

    public function HistorialCita(Request $request, $id_cita)
    {
        $datos = request();

        $cita = Citas::find($id_cita);

        if ($datos["tipo"] == 'Agregar') {
            Historial::create([

                'id_doctor'=>$cita->id_doctor,
                'id_cliente'=>$cita->id_cliente,
                'id_cita'=>$cita->id,
                'fecha'=>$cita->inicio,
                'nota'=>$datos["nota"],

            ]);

            return redirect('Cita/'.$id_cita)->with('HistorialAgredado','OK');

        }else{
            Historial::where('id_cita',$id_cita)->update([

                'nota'=>$datos["nota"],

            ]);

            return redirect('Cita/'.$id_cita)->with('HistorialActualizado','OK');
        }
    }
}

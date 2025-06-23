<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\User;
use App\Models\Clientes;
use App\Models\Ajustes;
use App\Models\Historial;
use App\Models\ImgHistorial;
use App\Models\Receta;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Elibyy\TCPDF\Facades\TCPDF;

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
        $ajustes = Ajustes::first(); 
        $especialidades = Especialidad::where('estado','Activo')->get(); 

        $citas = Citas::where('id_doctor',$id_doctor)->get();

        return view('modulos.citas.Calendario', compact('doctor','clientes','citas','ajustes','especialidades'));
    }

    public function AgendarCita(Request $request)
    {   
        $datos = request();

        // Validar si el paciente ya tiene una cita en ese rango horario con otro doctor
        $existeCita = DB::table('citas')
            ->where('id_cliente', $datos['id_cliente'])
            ->where(function ($query) use ($datos) {
                $query->whereBetween('inicio', [$datos['inicio'], $datos['fin']])
                    ->orWhereBetween('fin', [$datos['inicio'], $datos['fin']])
                    ->orWhere(function ($query) use ($datos) {
                        $query->where('inicio', '<=', $datos['inicio'])
                                ->where('fin', '>=', $datos['fin']);
                    });
            })
            ->exists();

        if ($existeCita) {
            return back()->with('error', 'OK');
        }

        if ($datos["nota"] == '') {
            $nota = 'Sin Nota';
        }else{
            $nota = $datos["nota"];
        }

        Citas::create([

            'id_doctor'=>$datos["id_doctor"],
            'id_cliente'=>$datos["id_cliente"],
            'id_especialidad'=>$datos["id_especialidad"],
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

        if ($cita) {
            $cita->estado = 'Cancelado';
            $cita->save();

            return redirect('Calendario/' . $cita->id_doctor);
        }

        return back()->with('error', 'Cita no encontrada');
    }


    public function VerCitasHoy($id_doctor)
    {
        $doctor = User::find($id_doctor);

        $ajustes = Ajustes::find(1);

        date_default_timezone_set($ajustes["zona_horaria"]);

        $fechaHoy = date('Y-m-d');

        $citas = Citas::where('id_doctor',$id_doctor)->where('inicio','LIKE',$fechaHoy.' %')->get();

        $citasHistorial = Citas::where('id_doctor', $id_doctor)->whereDate('inicio', '<', $fechaHoy)->get();

        return view('modulos.citas.Citas-Hoy', compact('doctor','citas','citasHistorial'));
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
        // $cita = Citas::find($id_cita);
        $cita = Citas::with('especialidad')->find($id_cita);

        $cliente = Clientes::find($cita->id_cliente);
        $doctor = Clientes::find($cita->id_doctor);

        $historial = Historial::where('id_cita',$id_cita)->first();

        if($historial){
            $imagenes = DB::select('select * from img_historial where id_historial = '.$historial->id);
        }else{
            $imagenes = "";
        }

        $receta = Receta::where('id_cita',$cita->id)->first();

        return view('modulos.citas.Cita', compact('cita','cliente','doctor','historial','imagenes','receta'));
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

    public function ImgHistorial(Request $request,$id_cita)
    {
        $datos = request();

        $cita = Citas::find($id_cita);

        $historial = Historial::where('id_cita',$id_cita)->first();
        $cliente = Clientes::find($cita->id_cliente);

        $rutaImg = $datos["imagenH"]->store('Clientes/'.$cliente->nombre.'-'.$cliente->documento.'/Historial-Clinico/', 'public'); 

        DB::table('img_historial')->insert(['id_historial'=>$historial->id, 'imagen'=>$rutaImg]);

        return redirect('Cita/'.$id_cita);
    }

    public function BorrarImgHistorial($id_imagen)
    {
        $imagen = ImgHistorial::find($id_imagen);

        Storage::delete('public/'.$imagen->imagen);

        ImgHistorial::destroy($id_imagen);

        $historial = Historial::where('id',$imagen->id_historial)->first();

        return redirect('Cita/'.$historial->id_cita);   
    }

    public function HistorialCliente($id_cliente)
    {
        $historial = Historial::orderBy('fecha','desc')->where('id_cliente',$id_cliente)->get();

        $cliente = Clientes::find($id_cliente);

        return view('modulos.citas.HistorialCliente', compact('historial','cliente'));
    }

    public function Receta(Request $request, $id_cita)
    {
        $datos = request();

        if ($datos["tipo"] == 'Crear') {
            Receta::create(['receta'=>$datos["receta"],'id_cita'=>$id_cita]);

            return redirect('Cita/'.$id_cita)->with('RecetaCreada','OK');
        }else{

            Receta::where('id_cita',$id_cita)->update(['receta'=>$datos["receta"]]);

            return redirect('Cita/'.$id_cita)->with('RecetaActualizada','OK');
        }

    }

    public function RecetaPDF($id_receta)
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P','mm','A4',true,'UTF-8',false);

        $pdf->SetCreator('Doctor');
        $pdf->SetTitle('Receta');
        $pdf->SetMargins(10,10,10,false);
        $pdf->SetAutoPageBreak(true,20);
        $pdf->AddPage();

        $receta= Receta::find($id_receta);
        $cita = Citas::find($receta->id_cita);
        $cliente = Clientes::find($cita->id_cliente);
        $doctor = User::find($cita->id_doctor);
        $ajustes = Ajustes::find(1);

        $logo = storage_path('app/public/logo.png');
        $pdf->Image($logo, 150, 10 ,40, '','','','T',false,300,'',false,false,0,false,false,false);

        $html = ' 
                <h1></h1>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th><h1><u>RECETA</u></h1></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>

                <h3>Doctor: '.$doctor->name.'</h3>
                <h3>Paciente: '.$cliente->nombre.'</h3>
                <h2>Receta: '.$receta->receta.'</h2>

                <p>'.$ajustes["direccion"].' || '.$ajustes["telefono"].'</p>
                               
                ';

        $pdf->writeHTML($html, true, false, true,false,'');

        $pdf->OutPut('Receta-'.$cliente->nombre.'-'.$receta->id.'.pdf','I');

    }
}

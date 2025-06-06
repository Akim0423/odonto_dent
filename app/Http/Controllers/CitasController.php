<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\User;
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
        $doctores = User::where('rol','doctor')->get();

        return view('modulos.citas.Citas', compact('doctores'));
    }

    public function Calendario($id_doctor)
    {
        $doctor = User::find($id_doctor);

        return view('modulos.citas.Calendario', compact('doctor'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Citas $citas)
    {
        //
    }

    public function edit(Citas $citas)
    {
        //
    }

    public function update(Request $request, Citas $citas)
    {
        //
    }

    public function destroy(Citas $citas)
    {
        //
    }
}

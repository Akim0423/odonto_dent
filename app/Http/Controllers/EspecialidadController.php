<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{

    public function index()
    {
        $especialidades = Especialidad::where('estado', 'Activo')->get();
        $especialidadesInactiva = Especialidad::where('estado', 'Inactivo')->get();

        return view('modulos.clientes.especialidad', compact('especialidades','especialidadesInactiva'));
    }


    public function store(Request $request)
    {
        Especialidad::create([
            'nombre'=>$request->nombre,
            'precio'=>$request->precio,
            'duracion_aprox'=>$request->duracion_aprox,
            'estado'=>'Activo'
        ]);

        return redirect('Especialidad')->with('EspecialidadAgregada','OK');
    }

    public function reactivar($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->estado = 'Activo';
        $especialidad->save();

        return redirect('Especialidad')->with('EspecialidadReactivado', 'OK');
    }

    public function show(Especialidad $especialidad)
    {
        //
    }

    public function edit(Especialidad $especialidad)
    {
        //
    }

    public function update(Request $request, Especialidad $especialidad)
    {
        //
    }

    public function destroy($id_especialidad)
    {
        Especialidad::where('id',$id_especialidad)->update(['estado'=>'Inactivo']);

        return redirect('Especialidad')->with('EspecialidadDesactivado', 'OK');
    }
}

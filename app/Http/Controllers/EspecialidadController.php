<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{

    public function index()
    {
        $especialidadesActivas = Especialidad::where('estado', 'Activo')->get();
        $especialidadesInactiva = Especialidad::where('estado', 'Inactivo')->get();

        return view('modulos.clientes.especialidad', compact('especialidadesActivas','especialidadesInactiva'));
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

    public function edit($id_especialidad)
    {
        $especialidadesActivas = Especialidad::where('estado', 'Activo')->get();
        $especialidadesInactiva = Especialidad::where('estado', 'Inactivo')->get();
        $especialidad = Especialidad::find($id_especialidad);

        return view('modulos.clientes.especialidad', compact('especialidadesActivas', 'especialidadesInactiva', 'especialidad'));
    }


    public function update(Request $request, $id_especialidad)
    {
        $especialidad = Especialidad::find($id_especialidad);

        $especialidad->update($request->all());

        return redirect('Especialidad')->with('EspecialidadActualizada', 'OK');
    }


    public function destroy($id_especialidad)
    {
        Especialidad::where('id',$id_especialidad)->update(['estado'=>'Inactivo']);

        return redirect('Especialidad')->with('EspecialidadDesactivado', 'OK');
    }
}

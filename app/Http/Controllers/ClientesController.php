<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{

    public function index()
    {

        $clientesActivos  = Clientes::where('estado', 1)->get();
        $clientesInactivos = Clientes::where('estado', 0)->get();
         
        return view('modulos.clientes.clientes', compact('clientesActivos', 'clientesInactivos'));
    }

    public function create()
    {
        return view('modulos.clientes.crear-clientes');
    }

    public function store(Request $request)
    {
        $datos = request()->validate([

            'nombre' =>["string",'max:255'],
            'email' =>["email",'unique:clientes'],
            'documento' =>["string",'unique:clientes'],
            'telefono' =>["string"],
            'direccion' =>["string"]
        ]);

        Clientes::create([

            'nombre'=>$datos["nombre"],
            'email'=>$datos["email"],
            'documento'=>$datos["documento"],
            'telefono'=>$datos["telefono"],
            'direccion'=>$datos["direccion"],
            'estado'=>1,
        ]);

        return redirect('Clientes')->with('ClienteAgregado', 'OK');
    }

    public function reactivar($id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->estado = 1;
        $cliente->save();

        return redirect('Clientes')->with('ClienteReactivado', 'OK');
    }


    public function show(Clientes $clientes)
    {
        
    }

    public function edit(Clientes $clientes)
    {
        
    }

    public function update(Request $request, Clientes $clientes)
    {
        
    }

    public function destroy($id_clientes)
    {
        Clientes::where('id',$id_clientes)->update(['estado'=>0]);

        return redirect('Clientes');
    }
}

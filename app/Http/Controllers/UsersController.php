<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ajustes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{

    public function Ajustes()
    {
        $ajustes = Ajustes::find(1);

        return view('modulos.inicio', compact('ajustes'));
    }

    // public function create()
    // {
    //     User::create([
    //         'name' => 'Alejandro',
    //         'email' => 'admin@gmail.com',
    //         'password' => Hash::make('123'),
    //         'foto' =>'',
    //         'rol' =>'administrador',
    //         'estado' => 'disponible',
    //     ]);
    // }

    public function ActualizarAjustes(Request $request)
    {
        $datos = request();
    
        $ajustes = Ajustes::find(1);
 
        $ajustes->telefono = $datos["telefono"];
        $ajustes->direccion = $datos["direccion"];
        $ajustes->zona_horaria = $datos["zona_horaria"];

        if(request('logo')){

            Storage::delete('public/logo.png');

            $datos["logo"]->storeAs('/','logo.png','public');
        }

        $ajustes->save();

        return redirect('Inicio');
    }

    public function ActualizarMisDatos(Request $request){
        $datos = request();

        if(auth()->user()->email != request('email')){

            if(request('password')){
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users'],
                    'password' =>['required', 'string', 'min:3'],
                ]);
            }else{
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users'],
                ]);
            }

        }else{

            if(request('password')){
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email'],
                    'password' =>['required', 'string', 'min:3'],
                ]);
            }else{
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email'],
                ]);
            }

        }

        if(request('fotoPerfil')){
            $fotoAnterior = auth()->user()->foto;

            if ($fotoAnterior) {
                $path = storage_path('app/public/'.$fotoAnterior);

                if (file_exists($path) && is_file($path)) {
                    unlink($path);
                }
            }

            $rutaImg = $request["fotoPerfil"]->store('Usuarios/'.$datos["name"].'-'.$datos["email"], 'public');
        } else {
            $rutaImg = auth()->user()->foto;
        }

        if (isset($datos["password"])) {

            DB::table('users')->where('id', auth()->user()->id)->update([
                'name'=>$datos["name"],
                'email'=>$datos["email"],
                'foto'=>$rutaImg,
                'password'=>Hash::make($datos["password"])
            ]);

        }else{

            DB::table('users')->where('id', auth()->user()->id)->update([
                'name'=>$datos["name"],
                'email'=>$datos["email"],
                'foto'=>$rutaImg,
            ]);
            
        }

        return redirect('mis-datos');
    }

    public function index()
    {

        if (auth()->user()->rol != 'administrador') {
            return redirect('Inicio');
        }

        $users = User::all();

        return view('modulos.users.usuarios', compact('users'));
    }

    public function store(Request $request)
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

        return redirect('Usuarios')->with('UsuarioCreado','OK');

    }

    public function edit($id_usuario)
    {
        $users = User::all();
        $usuario = User::find($id_usuario);

        return view('modulos.users.usuarios', compact('users','usuario'));
    }

    public function update(Request $request, $id_usuario)
    {
        $usuario = User::find($id_usuario);

        if($usuario["email"] != request('email')){

            if(request('password')){

                $datos = request()->validate([

                    'name'=>['required','string','max:255'],
                    'rol'=>['required'],
                    'email'=>['required','unique:users'],
                    'password'=>['string','min:3']
                ]);

            }else{

                $datos = request()->validate([
                    
                    'name'=>['required','string','max:255'],
                    'rol'=>['required'],
                    'email'=>['required','unique:users'],
                ]); 

            }
            
        }else{
            if(request('password')){

                $datos = request()->validate([

                    'name'=>['required','string','max:255'],
                    'rol'=>['required'],
                    'email'=>['required'],   
                    'password'=>['string','min:3']
                ]);

            }else{

                $datos = request()->validate([
                    
                    'name'=>['required','string','max:255'],
                    'rol'=>['required'],
                    'email'=>['required'],       
                ]); 

            }
        }

        if(request('password')){

            DB::table('users')->where('id',$id_usuario)->update([

                'name'=>$datos["name"],
                'rol'=>$datos["rol"],
                'email'=>$datos["email"],
                'password'=>Hash::make($datos["password"]),

            ]);

        }else{

            DB::table('users')->where('id',$id_usuario)->update([

                'name'=>$datos["name"],
                'rol'=>$datos["rol"],
                'email'=>$datos["email"],

            ]);
        }
        
        return redirect('Usuarios')->with('UsuarioActualizado','OK');
    }

    public function destroy($id_usuario)
    {
        $usuario = User::find($id_usuario);

        $exp = explode('/', $usuario->foto);

        if (Storage::delete('public/'.$usuario->foto)) {
            
            Storage::deleteDirectory('public/'.$exp[0].'/'.$exp[1]);
        }

        User::destroy($id_usuario);

        return redirect('Usuarios');
    }
}

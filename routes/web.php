<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClientesController;

Route::get('/', function () {
    return view('modulos.users.ingresar');
});

// Route::get('CrearUsuario',[UsersController::class,'create']);

Auth::routes();

//Usuarios
Route::get('Inicio', [UsersController::class, 'Ajustes']);
Route::post('Inicio', [UsersController::class, 'ActualizarAjustes']);
Route::get('/mis-datos',function(){
    return view('modulos.users.mis-datos');
});
Route::put('mis-datos',[UsersController::class, 'ActualizarMisDatos']);
Route::get('Usuarios',[UsersController::class, 'index']);
Route::post('Usuarios',[UsersController::class, 'store']);
Route::get('Editar-Usuario/{id_usuario}',[UsersController::class, 'edit']);
Route::put('Actualizar-Usuario/{id_usuario}',[UsersController::class, 'update']);
Route::get('Eliminar-Usuario/{id_usuario}',[UsersController::class, 'destroy']);

//Clientes
Route::get('Clientes',[ClientesController::class,'index']);
Route::get('Crear-Cliente',[ClientesController::class,'create']);
Route::post('Crear-Cliente',[ClientesController::class,'store']);

Route::put('Reactivar-Cliente/{id}', [ClientesController::class, 'reactivar']);
Route::get('Eliminar-Cliente/{id_clientes}',[ClientesController::class,'destroy']);
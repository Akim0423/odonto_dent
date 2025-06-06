<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CitasController;

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
Route::put('Usuarios',[UsersController::class, 'store']);
Route::get('Editar-Usuario/{id_usuario}',[UsersController::class, 'edit']);
Route::put('Actualizar-Usuario/{id_usuario}',[UsersController::class, 'update']);
Route::get('Eliminar-Usuario/{id_usuario}',[UsersController::class, 'destroy']);

//Clientes
Route::get('Clientes',[ClientesController::class,'index']);
Route::get('Crear-Cliente',[ClientesController::class,'create']);
Route::post('Crear-Cliente',[ClientesController::class,'store']);

Route::put('Reactivar-Cliente/{id}', [ClientesController::class, 'reactivar']);
Route::get('Eliminar-Cliente/{id_clientes}',[ClientesController::class,'destroy']);

//Doctor
Route::get('Doctores',[CitasController::class,'VerDoctores']);
Route::post('Doctores',[CitasController::class,'CrearDoctores']);
Route::put('Estado/{id_doctor}',[CitasController::class,'CambiarEstado']);

//Citas
Route::get('Citas',[CitasController::class,'index']);
Route::get('Calendario/{id_doctor}',[CitasController::class,'Calendario']);
Route::post('Calendario/{id_doctor}',[CitasController::class,'AgendarCita']);
Route::delete('Cancelar-Cita',[CitasController::class,'CancelarCita']);

Route::get('Citas-Hoy/{id_doctor}',[CitasController::class,'VerCitasHoy']);
Route::post('Citas-Hoy/{id_doctor}',[CitasController::class,'CambiarEstadoCita']);
Route::get('Cita/{id_cita}',[CitasController::class,'VerCita']);
Route::post('Finalizar-Cita/{id_cita}',[CitasController::class,'FinalizarCita']);

//Historial
Route::post('Cita/{id_cita}',[CitasController::class,'HistorialCita']);
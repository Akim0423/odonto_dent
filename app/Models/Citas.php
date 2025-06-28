<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    protected $table = 'citas';

    protected $fillable = [

        'id_doctor',
        'id_cliente',
        'id_especialidad',
        'tipo_cita',
        'nota',
        'estado',
        'inicio',
        'fin'
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fin' => 'datetime',
    ];


    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'id_cliente');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'id_doctor');
    }

    public function especialidad() 
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }
}

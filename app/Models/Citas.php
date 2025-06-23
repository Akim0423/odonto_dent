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
        'nota',
        'estado',
        'inicio',
        'fin'
    ];

    public $timestamps = false;

    public function CLIENTE()
    {
        return $this->belongsTo(Clientes::class, 'id_cliente');
    }

    public function ESPECIALIDAD() 
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }
}

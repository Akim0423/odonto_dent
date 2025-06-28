<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [

        'nombre',
        'precio',
        'duracion_aprox',
        'tipo',
        'estado'
    ];

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';

    protected $fillable = [

        'nombre',
        'documento',
        'email',
        'telefono',
        'direccion',
        'estado'
    ];

    public $timestamps = false;
}

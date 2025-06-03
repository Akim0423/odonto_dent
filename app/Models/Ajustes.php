<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajustes extends Model
{
    protected $table = 'ajustes';

    protected $fillable =[

        'telefono',
        'direccion',
        'zona_horaria'

    ];

    public $timestamps = false;
}

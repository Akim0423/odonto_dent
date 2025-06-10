<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = [
        'id_cita',
        'receta'
    ];

    public $timestamps = false;
}

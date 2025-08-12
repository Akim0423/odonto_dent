<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial_clinico';

    protected $fillable = [

        'id_doctor',
        'id_cliente',
        'id_cita',
        'fecha',
        'nota'
    ];

    public $timestamps = false;

    public function DOCTOR()
    {
        return $this->belongsTo(User::class, 'id_doctor');
    }

    public function cita()
    {
        return $this->belongsTo(Citas::class, 'id_cita');
    }
}

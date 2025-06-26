<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    protected $table = 'recordatorios';

    protected $fillable = [
        'id_cita',
        'id_secretaria',
        'email',
        'fecha_envio',
        'estado'
    ];

    public $timestamps = false;

    public function CITA()
    {
        return $this->belongsTo(Citas::class, 'id_cita');
    }

    public function SECRETARIA()
    {
        return $this->belongsTo(User::class, 'id_secretaria');
    }
}

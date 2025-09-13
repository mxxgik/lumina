<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquiposOElementos extends Model
{
    protected $table = 'equipos_o_elementos';
    protected $fillable = [
        'sn_equipo',
        'marca',
        'color',
        'tipo_elemento',
        'path_qr',
    ];

    public function historial()
    {
        return $this->hasMany(Historial::class, 'equipos_o_elementos_id');
    }

    public function aprendizEquipos()
    {
        return $this->hasMany(AprendizEquipos::class);
    }

    public function aprendiz()
    {
        return $this->belongsToMany(
            aprendiz::class,
            'aprendiz_equipos',
            'equipos_o_elementos_id',
            'aprendiz_id'
        );
    }
}

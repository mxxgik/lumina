<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AprendizEquipos extends Model
{
    protected $table = 'aprendiz_equipos';
    protected $fillable = [
        'aprendiz_id',
        'equipos_o_elementos_id',
    ];

    public function aprendiz(){
        return $this->belongsTo(Aprendiz::class);
    }

    public function equipos(){
        return $this->belongsTo(EquiposOElementos::class);
    }
}

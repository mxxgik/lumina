<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosEquipos extends Model
{
    protected $table = 'usuarios_equipos';
    protected $fillable = [
        'usuarios_id',
        'equipos_o_elementos_id',
    ];

    public function usuarios(){
        return $this->belongsTo(Usuarios::class);
    }

    public function equipos(){
        return $this->belongsTo(EquiposOElementos::class);
    }
}

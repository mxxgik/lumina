<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'edad',
        'numero_telefono',
        'path_foto',
        'rol'
    ];

    public function formacion(){
        return $this->hasMany(Formacion::class);
    }

    public function usuariosEquipos()
    {
        return $this->hasMany(UsuariosEquipos::class);
    }

    public function historial()
    {
        return $this->hasMany(Historial::class, 'usuarios_id');
    }

    public function equipos()
    {
        return $this->belongsToMany(
            EquiposOElementos::class,
            'usuarios_equipos',
            'usuarios_id',
            'equipos_o_elementos_id'
        );
    }

    public function elementosAdicionales()
    {
        return $this->belongsToMany(
            ElementosAdicionales::class,
            'elementos_adicionales_usuarios',
            'usuarios_id',
            'elementos_adicionales_id'
        );
    }
}

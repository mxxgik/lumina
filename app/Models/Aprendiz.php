<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aprendiz extends Model
{
    protected $table = 'aprendiz';
    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'edad',
        'numero_telefono',
        'path_foto',
        'rol'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formacion(){
        return $this->hasMany(Formacion::class);
    }

    public function aprendizEquipos()
    {
        return $this->hasMany(AprendizEquipos::class);
    }

    public function historial()
    {
        return $this->hasMany(Historial::class, 'aprendiz_id');
    }

    public function equipos()
    {
        return $this->belongsToMany(
            EquiposOElementos::class,
            'aprendiz_equipos',
            'aprendiz_id',
            'equipos_o_elementos_id'
        );
    }

    public function elementosAdicionales()
    {
        return $this->belongsToMany(
            ElementosAdicionales::class,
            'elementos_adicionales_aprendiz',
            'aprendiz_id',
            'elementos_adicionales_id'
        );
    }
}

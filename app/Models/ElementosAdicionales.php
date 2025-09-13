<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementosAdicionales extends Model
{
    protected $table = 'elementos_adicionales';
    protected $fillable = [
        'tipos_elementos_adicionales',
        'nombre_elemento_adicionales',
    ];
    public function elementos_adicionales_aprendiz(){
        return $this->hasMany(ElementosAdicionalesAprendiz::class);
    }
    public function historial()
    {
        return $this->hasManyThrough(
            Historial::class,
            ElementosAdicionalesAprendiz::class,
            'elementos_adicionales_id',
            'elementos_adicionales_aprendiz_id',
            'id',
            'id'
        );
    }

    public function aprendiz()
    {
        return $this->belongsToMany(
            aprendiz::class,
            'elementos_adicionales_aprendiz',
            'elementos_adicionales_id',
            'aprendiz_id'
        );
    }
}

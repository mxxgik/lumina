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
    public function elementos_adicionales_usuarios(){
        return $this->hasMany(ElementosAdicionalesUsuarios::class);
    }
    // ... existing code ...
    public function historial()
    {
        return $this->hasManyThrough(
            Historial::class,
            ElementosAdicionalesUsuarios::class,
            'elementos_adicionales_id',
            'elementos_adicionales_usuarios_id',
            'id',
            'id'
        );
    }

    public function usuarios()
    {
        return $this->belongsToMany(
            Usuarios::class,
            'elementos_adicionales_usuarios',
            'elementos_adicionales_id',
            'usuarios_id'
        );
    }
}

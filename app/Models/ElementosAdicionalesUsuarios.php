<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementosAdicionalesUsuarios extends Model
{
    protected $table = 'elementos_adicionales_usuarios';
    protected $fillable = [
        'usuarios_id',
        'elementos_adicionales_id',
    ];

    public function usuarios(){
        return $this->belongsTo(Usuarios::class);
    }
    public function elementos_adicionales(){
        return $this->belongsTo(ElementosAdicionales::class);
    }

    public function historial(){
        return $this->hasMany(Historial::class, 'elementos_adicionales_usuarios_id');
    }
}

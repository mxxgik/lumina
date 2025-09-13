<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementosAdicionalesAprendiz extends Model
{
    protected $table = 'elementos_adicionales_aprendiz';
    protected $fillable = [
        'aprendiz_id',
        'elementos_adicionales_id',
    ];

    public function aprendiz(){
        return $this->belongsTo(Aprendiz::class);
    }
    public function elementos_adicionales(){
        return $this->belongsTo(ElementosAdicionales::class);
    }

    public function historial(){
        return $this->hasMany(Historial::class, 'elementos_adicionales_aprendiz_id');
    }
}

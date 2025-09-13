<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial';
    protected $fillable = [
        'aprendiz_id',
        'equipos_o_elementos_id',
        'elementos_adicionales_aprendiz_id',
        'fecha',
        'hora_ingreso',
        'hora_salida',
    ];

    public function usuario()
    {
        return $this->belongsTo(Aprendiz::class);
    }

    public function equipoOElemento()
    {
        return $this->belongsTo(EquiposOElementos::class,'equipos_o_elementos_id');
    }

    public function elementoAdicional()
    {
        return $this->belongsTo(ElementosAdicionalesAprendiz::class, 'elementos_adicionales_aprendiz_id');
    }
}

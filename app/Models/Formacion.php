<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    protected $table = 'formacion';
    protected $fillable = [
        'aprendiz_id',
        'tipos_programas_id',
        'ficha',
        'nombre_programa',
        'fecha_inicio_programa',
        'fecha_fin_programa'
    ];
    public function tipos_programas(){
        return $this->belongsTo(TiposProgramas::class);
    }

    public function aprendiz(){
        return $this->belongsTo(Aprendiz::class);
    }
}

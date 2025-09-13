<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposProgramas extends Model
{
    protected $table = 'tipos_programas';
    protected $fillable = [
        'nivel_formacion',
    ];

    public function formacion(){
        return $this->hasMany(Formacion::class, 'formacion_id');
    }
}

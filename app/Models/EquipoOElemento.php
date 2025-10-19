<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoOElemento extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'equipos_o_elementos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sn_equipo',
        'marca',
        'color',
        'tipo_elemento',
        'descripcion',
        'path_qr',
        'path_foto_equipo_implemento',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The aprendices that belong to the equipo.
     */
    public function aprendices()
    {
        return $this->belongsToMany(Aprendiz::class, 'aprendiz_equipos', 'equipos_o_elementos_id', 'aprendiz_id');
    }

    /**
     * Get the historial for the equipo.
     */
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'equipos_o_elementos_id');
    }
}

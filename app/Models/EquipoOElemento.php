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
        'qr_hash',
        'path_foto_equipo_implemento',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The usuarios that belong to the equipo.
     */
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_equipos', 'equipos_o_elementos_id', 'usuario_id');
    }

    /**
     * Get the historial for the equipo.
     */
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'equipos_o_elementos_id');
    }

    /**
     * The elementos adicionales that belong to this equipo o elemento.
     */
    public function elementosAdicionales()
    {
        return $this->belongsToMany(ElementoAdicional::class, 'equipo_elemento_adicional', 'equipos_o_elementos_id', 'elementos_adicionales_id');
    }
}

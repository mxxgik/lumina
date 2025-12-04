<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementoAdicional extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'elementos_adicionales';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nombre_elemento',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The equipos o elementos that belong to this elemento adicional.
     */
    public function equipos()
    {
        return $this->belongsToMany(EquipoOElemento::class, 'equipo_elemento_adicional', 'elementos_adicionales_id', 'equipos_o_elementos_id');
    }
}

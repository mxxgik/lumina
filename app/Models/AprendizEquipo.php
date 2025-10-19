<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AprendizEquipo extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'aprendiz_equipos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'aprendiz_id',
        'equipos_o_elementos_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the aprendiz that owns the pivot.
     */
    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class);
    }

    /**
     * Get the equipo that owns the pivot.
     */
    public function equipo()
    {
        return $this->belongsTo(EquipoOElemento::class, 'equipos_o_elementos_id');
    }
}

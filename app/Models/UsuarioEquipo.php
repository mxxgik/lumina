<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsuarioEquipo extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'usuario_equipos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'usuario_id',
        'equipos_o_elementos_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the usuario that owns the pivot.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Get the equipo that owns the pivot.
     */
    public function equipo()
    {
        return $this->belongsTo(EquipoOElemento::class, 'equipos_o_elementos_id');
    }
}

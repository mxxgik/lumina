<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'historial';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'usuario_id',
        'equipos_o_elementos_id',
        'ingreso',
        'salida',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'ingreso' => 'datetime',
        'salida' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the usuario that owns the historial.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Get the equipo that owns the historial.
     */
    public function equipo()
    {
        return $this->belongsTo(EquipoOElemento::class, 'equipos_o_elementos_id');
    }
}

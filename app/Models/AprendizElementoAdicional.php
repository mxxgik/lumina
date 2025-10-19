<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AprendizElementoAdicional extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'aprendiz_elementos_adicionales';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'aprendiz_id',
        'elementos_adicionales_id',
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
     * Get the elemento adicional that owns the pivot.
     */
    public function elementoAdicional()
    {
        return $this->belongsTo(ElementoAdicional::class, 'elementos_adicionales_id');
    }

    /**
     * Get the historial elementos adicionales for this relationship.
     */
    public function historialElementosAdicionales()
    {
        return $this->hasMany(HistorialElementoAdicional::class, 'aprendiz_elemento_adicional_id');
    }
}

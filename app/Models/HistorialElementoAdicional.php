<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialElementoAdicional extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'historial_elementos_adicionales';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'historial_id',
        'aprendiz_elemento_adicional_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the historial that owns the historial elemento adicional.
     */
    public function historial()
    {
        return $this->belongsTo(Historial::class);
    }

    /**
     * Get the aprendiz elemento adicional that owns this record.
     */
    public function aprendizElementoAdicional()
    {
        return $this->belongsTo(AprendizElementoAdicional::class, 'aprendiz_elemento_adicional_id');
    }
}

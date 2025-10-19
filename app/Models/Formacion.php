<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'formacion';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'aprendiz_id',
        'tipos_programas_id',
        'ficha',
        'nombre_programa',
        'fecha_inicio_programa',
        'fecha_fin_programa',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_inicio_programa' => 'date',
        'fecha_fin_programa' => 'date',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the aprendiz that owns the formacion.
     */
    public function aprendiz()
    {
        return $this->belongsTo(Aprendiz::class);
    }

    /**
     * Get the tipo programa that owns the formacion.
     */
    public function tipoPrograma()
    {
        return $this->belongsTo(TipoPrograma::class, 'tipos_programas_id');
    }
}

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
        'nivel_formacion_id',
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
     * Get the nivel formacion that owns the formacion.
     */
    public function nivelFormacion()
    {
        return $this->belongsTo(NivelFormacion::class, 'nivel_formacion_id');
    }

    /**
     * Get the users for the formacion.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'formacion_id');
    }
}

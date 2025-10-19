<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aprendiz extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'aprendiz';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'tipo_documento',
        'documento',
        'edad',
        'numero_telefono',
        'path_foto',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'edad' => 'integer',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the user that owns the aprendiz.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the formacion for the aprendiz.
     */
    public function formaciones()
    {
        return $this->hasMany(Formacion::class);
    }

    /**
     * The equipos that belong to the aprendiz.
     */
    public function equipos()
    {
        return $this->belongsToMany(EquipoOElemento::class, 'aprendiz_equipos', 'aprendiz_id', 'equipos_o_elementos_id');
    }

    /**
     * The elementos adicionales that belong to the aprendiz.
     */
    public function elementosAdicionales()
    {
        return $this->belongsToMany(ElementoAdicional::class, 'aprendiz_elementos_adicionales', 'aprendiz_id', 'elementos_adicionales_id');
    }

    /**
     * Get the historial for the aprendiz.
     */
    public function historiales()
    {
        return $this->hasMany(Historial::class);
    }
}

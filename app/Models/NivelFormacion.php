<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelFormacion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'nivel_formacion';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nivel_formacion',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the formaciones for the nivel formacion.
     */
    public function formaciones()
    {
        return $this->hasMany(Formacion::class, 'nivel_formacion_id');
    }
}

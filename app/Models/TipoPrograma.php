<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrograma extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'tipos_programas';

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
     * Get the formaciones for the tipo programa.
     */
    public function formaciones()
    {
        return $this->hasMany(Formacion::class, 'tipos_programas_id');
    }
}

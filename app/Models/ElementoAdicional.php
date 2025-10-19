<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementoAdicional extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'elementos_adicionales';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tipo_elemento',
        'nombre_elemento',
        'path_foto_elemento',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The aprendices that belong to the elemento adicional.
     */
    public function aprendices()
    {
        return $this->belongsToMany(Aprendiz::class, 'aprendiz_elementos_adicionales', 'elementos_adicionales_id', 'aprendiz_id');
    }
}

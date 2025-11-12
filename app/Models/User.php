<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'role_id',
        'formacion_id',
        'nombre',
        'apellido',
        'tipo_documento',
        'documento',
        'edad',
        'numero_telefono',
        'path_foto',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'password' => 'hashed',
        'edad' => 'integer',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the formacion that owns the user.
     */
    public function formacion()
    {
        return $this->belongsTo(Formacion::class);
    }

    /**
     * The equipos that belong to the user.
     */
    public function equipos()
    {
        return $this->belongsToMany(EquipoOElemento::class, 'usuario_equipos', 'usuario_id', 'equipos_o_elementos_id');
    }

    /**
     * Alias for equipos() method - equipos o elementos.
     */
    public function equipoOElementos()
    {
        return $this->equipos();
    }

    /**
     * Get the historial for the user.
     */
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'usuario_id');
    }
}

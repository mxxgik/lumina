<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nombre_rol',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the users for the role.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}

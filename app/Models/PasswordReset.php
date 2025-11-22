<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'password_reset_tokens';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;
    const UPDATED_AT = null;
}

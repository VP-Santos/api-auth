<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $table = 'email_verifications';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
    ];
}

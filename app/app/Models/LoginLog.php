<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_logs';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];
}

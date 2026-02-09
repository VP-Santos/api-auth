<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwoFactor extends Model
{
    protected $table = 'two_factor';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];
}

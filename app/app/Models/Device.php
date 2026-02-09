<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];
}

<?php

namespace App\Domains\Auth\Exceptions;

use Exception;

class LoginException extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'message'       => 'incorrect email or password.',
        ], 400);
    }
}

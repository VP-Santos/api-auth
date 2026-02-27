<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidTokenException extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'code'          => 'TOKEN_EXPIRED',
            'message'       => 'Your access token has expired and is no longer valid.',
        ], 401);
    }
}

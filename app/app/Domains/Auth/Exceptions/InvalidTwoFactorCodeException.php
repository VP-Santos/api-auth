<?php

namespace App\Domains\Auth\Exceptions;

use Exception;

class InvalidTwoFactorCodeException extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'code'          => 'TOKEN_EXPIRED',
            'message'       => 'The code has expired or is invalid.',
        ], 401);
    }
}

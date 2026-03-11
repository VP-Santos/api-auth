<?php

namespace App\Domains\Auth\Exceptions;

use Exception;

class InvalidTokenEmailNotFound extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'code'          => 'TOKEN_NOT_FOUND',
            'message'       => 'Email verification token not found.',
        ], 404);
    }
}

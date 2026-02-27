<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidCredentialsException extends Exception
{
        public function render()
    {
        return response()->json([
            'success'       => false,
            'message'       => 'Your access token has expired and is no longer valid.',
        ], 401);
    }
}

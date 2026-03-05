<?php

namespace App\Exceptions\Auth;

use Exception;

class SamePasswordException extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'message'       => 'The new password cannot be the same as the current password.',
        ], 422);
    }
}

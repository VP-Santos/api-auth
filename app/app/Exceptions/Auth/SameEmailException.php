<?php

namespace App\Exceptions\Auth;

use Exception;

class SameEmailException extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'message'       => 'The email informed is different from the registered one.',
        ], 422);
    }
}

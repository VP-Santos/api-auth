<?php

namespace App\Domains\Auth\Exceptions;

use Exception;

class EmailNotVerifiedException extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'message'       => 'Your Email not yet verified.',
        ], 401);
    }
}

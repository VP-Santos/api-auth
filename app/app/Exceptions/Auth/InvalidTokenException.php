<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidTokenException extends Exception
{
    protected $httpCode;

    public function __construct(string $message = "Invalid token.", int $httpCode = 401)
    {
        parent::__construct($message);
        $this->httpCode = $httpCode;
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'code'    => 'TOKEN_INVALID',
            'message' => $this->getMessage(),
        ], $this->httpCode);
    }
}

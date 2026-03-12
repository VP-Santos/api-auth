<?php

namespace App\Domains\Auth\Exceptions;

use Exception;

class FlowException extends Exception
{
    protected $httpCode;

    public function __construct(string $message = "Cannot resend token. Please start the login flow first.", int $httpCode = 400)
    {
        parent::__construct($message);
        $this->httpCode = $httpCode;
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'code'    => 'FLOW_INVALID',
            'message' => $this->getMessage(),
        ], $this->httpCode);
    }
}
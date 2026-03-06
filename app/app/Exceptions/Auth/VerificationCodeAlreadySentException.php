<?php

namespace App\Exceptions\Auth;

use Exception;

class VerificationCodeAlreadySentException extends Exception
{
    protected $httpCode;

    public function __construct(string $message = "Verification code already sent. Please wait before requesting a new one.", int $httpCode = 429)
    {
        parent::__construct($message);
        $this->httpCode = $httpCode;
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'code'    => 'VERIFICATION_CODE_ALREADY_SENT',
            'message' => $this->getMessage(),
        ], $this->httpCode);
    }
}
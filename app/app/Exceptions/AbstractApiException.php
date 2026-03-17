<?php

namespace App\Exceptions;

use Exception;

abstract class AbstractApiException extends Exception
{
    protected int $httpCode = 400;
    protected string $errorCode = 'API_ERROR';

    public function render()
    {
        return response()->json([
            'success' => false,
            'code'    => $this->errorCode,
            'message' => $this->getMessage(),
        ], $this->httpCode);
    }
}

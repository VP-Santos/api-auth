<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidTwoFactorCodeException extends Exception
{
    public function render()
    {
        return response()->json([
            'success'       => false,
            'code'          => 'TOKEN_EXPIRED',
            'message'       => 'O seu token de acesso expirou e não é mais válido.',
            'help'          => 'Obtenha um novo token através da rota de refresh ou login.'
        ], 401);
    }
}

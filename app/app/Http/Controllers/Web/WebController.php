<?php

namespace App\Http\Controllers\Web;

use App\Domains\Auth\Services\EmailVerificationService;
use Illuminate\Http\Request;

class WebController
{
    public function home(Request $request)
    {
        $token = $request->query('token', null);
        if ($token) {
            $verification = new EmailVerificationService;
            $response = $verification->verify($token);
        }

        return view('web.wellcome');
    }

    public function register()
    {
        return view('web.register');
    }

    public function login()
    {
        return view('web.login');
    }
    public function forgotPassword()
    {
        return view('web.forgotPassword');
    }
    public function resetPassword()
    {
        return view('web.resetPassword');
    }
}

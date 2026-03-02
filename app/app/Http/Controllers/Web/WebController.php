<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class WebController
{
    public function home(Request $request)
    {
        $token = $request->query('token', null);
        return view('web.wellcome');
        // dd($token);
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

<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class WebController
{
    public function home(Request $request)
    {
        $token = $request->query('token', null);
        return view('wellcome');
        // dd($token);
    }

    public function register()
    {
        return view('register');
    }
    public function login()
    {
        // return view('login');
    }
}

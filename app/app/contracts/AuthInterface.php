<?php

namespace App\Contracts;

use App\Http\Requests\Users\FormLoginRequest;
use App\Http\Requests\Users\FormStoreUsers;
use App\Http\Requests\Users\FormUpdateRequest;

interface AuthInterface
{   
    public function logout();
    public function show();
    public function register(FormStoreUsers $request);
    public function login(FormLoginRequest $request);
    public function update(FormUpdateRequest $request);
}
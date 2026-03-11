<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthInterface;
use App\Http\Requests\Users\FormLoginRequest;
use App\Http\Requests\Users\FormStoreUsers;
use App\Http\Requests\Users\FormUpdateRequest;
use Exception;

abstract class AbstractAuthController implements AuthInterface
{
    abstract function storeRequest($user);
    abstract function loginRequest($user);
    abstract function showRequest();
    abstract function logoutRequest();
    abstract function updateRequest();


    public function register(FormStoreUsers $request)
    {
        try {

            $userData = $request->validated();

            return $this->storeRequest($userData);
        } catch (Exception $e) {
            return response()->json(['status' => 'error'], 400);
        }
    }
    public function login(FormLoginRequest $request)
    {
        try {
            $userData = $request->validated();

            return $this->loginRequest($userData);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
    public function update(FormUpdateRequest $userData)
    {
        try {
            return $this->updateRequest();
        } catch (Exception $e) {
            return response()->json(['status' => 'error'], 400);
        }
    }
    public function logout()
    {
        try {
            return $this->logoutRequest();
        } catch (Exception $e) {
            return response()->json(['status' => 'error'], 400);
        }
    }
    public function show()
    {
        try {
            return $this->showRequest();
        } catch (Exception $e) {
            return response()->json(['status' => 'error'], 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Http\Requests\Users\{
    FormLoginRequest,
    FormStoreUsers,
    FormUpdateUser,
    VerifyTwoFactorRequest
};
use App\Mail\{
    TwoFactorVerify,
    VerifyEmailMail
};
use App\Models\{
    EmailVerification,
    TwoFactor,
    User
};
use App\Services\VerificationService;
use Illuminate\Support\Facades\{
    DB,
    Hash,
    Mail,
    Log
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AuthController
{
    private $authService;
    private $verifyService;

    public function __construct()
    {
        $this->authService = new AuthService;
        $this->verifyService = new VerificationService;
    }
    public function register(FormStoreUsers $request)
    {
        try {

            $this->authService->registerUser($request->validated());

            return response()->json([
                'success'   => true,
                'message'  => 'Account created. Please verify your email.',
            ], 201);
        } catch (\Throwable $e) {
        }
    }

    public function verifyEmail(Request $request)
    {
        $token = $request->query('token', null);

        if (!$token) {
            throw new \Exception('the token not found', 400);
        }

        $tokenCreated = $this->verifyService->verifyTokenEmail($token);

        return response()->json([
            'success' => true,
            'message' => 'successful verification',
            'token' => $tokenCreated
        ]);
    }

    public function login(FormLoginRequest $request)
    {
        $this->authService->login($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Code sent, please check your email.',
        ], 200);
    }


    public function verifyTwoFactor(VerifyTwoFactorRequest $request)
    {
        $response = (object) $this->verifyService->verifyTwoFactor($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'successful login',
            'user_id' => $response->user->id,
            'token' => $response->token,
        ], 200);
    }

    public function show()
    {
        try {

            $user = request()->user();

            return response()->json([
                'current_token'  => $user['current_token'],
                'credenciais' => $user
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching the database.',
            ], 500);
        }
    }
    public function update(FormUpdateUser $request)
    {
        $this->authService->updateUser($request->validated(), $request->user());
        $userData = $request->validated();
    }
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            $user->currentAccessToken()->delete();

            return response()->json(['info' => 'user logged out'], 200);
        } catch (\Throwable $e) {
        }
    }

    public function resetPassword()
    {
        try {
        } catch (\Throwable $e) {
        }
    }

    public function refreshToken()
    {
        try {
        } catch (\Throwable $e) {
        }
    }
}

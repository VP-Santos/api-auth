<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\InvalidTokenEmailNotFound;
use App\Http\Requests\Users\{
    FormLoginRequest,
    FormStoreUsers,
    FormUpdateUser,
    VerifyTwoFactorRequest,
    ForgotPasswordRequest,
    ResendTokenRequest,
    ResetPasswordRequest,
    UpdatePasswordRequest,
    VerifyTokenEmailRequest
};
use App\Services\{
    VerificationService,
    AuthService
};


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
        $this->authService->registerUser($request->validated());

        return response()->json([
            'success'   => true,
            'message'  => 'Account created. Please verify your email.',
        ], 201);
    }

    public function verifyEmail(VerifyTokenEmailRequest $request)
    {
        $request->validated();
        $token = $request['token'];

        if (!$token) {
            throw new InvalidTokenEmailNotFound;
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
            'token' => $response->token,
        ], 200);
    }

    public function show()
    {
        $user = request()->user();

        return response()->json([
            'current_token'  => $user['current_token'],
            'credenciais' => $user
        ], 200);
    }
    public function update(FormUpdateUser $request)
    {
        $this->authService->updateUser($request->validated(), $request->user());
        $userData = $request->validated();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data updated successfully.'
            ],
            200
        );
    }
    public function logout()
    {
        $user = request()->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'user logged out'
        ], 200);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $this->authService->ForgetPassword($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'verify your email'
        ], 200);
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->verifyService->verifyResetPassword($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'password reset successfully'
        ], 200);
    }
    public function updatePassword(UpdatePasswordRequest $request) {}
    public function resendCodeEmail(ResendTokenRequest $request) {}
}

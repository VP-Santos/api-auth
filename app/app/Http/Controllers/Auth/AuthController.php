<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\InvalidTokenEmailNotFound;
use App\Http\Requests\Users\{
    FormLoginRequest,
    FormStoreUsers,
    FormUpdateUser,
    VerifyTwoFactorRequest,
    ForgotPasswordRequest,
    ResetPasswordRequest,
    UpdatePasswordRequest,
    VerifyTokenEmailRequest,
    ResendAuthenticationCodeRequest
};
use App\Services\{
    AuthService,
    EmailVerificationService,
    PasswordResetService,
    TwoFactorService
};

class AuthController
{
    public function __construct(
        private AuthService $authService,
        private EmailVerificationService $emailVerificationService,
        private TwoFactorService $twoFactorService,
        private PasswordResetService $passwordResetService 
    ) {}

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

        $tokenCreated = $this->emailVerificationService->verify($token);

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
        ]);
    }

    public function verifyTwoFactor(VerifyTwoFactorRequest $request)
    {
        $response = $this->twoFactorService->verify($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'successful login',
            'token' => $response['token'],
        ]);
    }

    public function show()
    {
        $user = request()->user();

        return response()->json([
            'current_token'  => $user['current_token'],
            'credenciais' =>  $user->only([
                'id',
                'name',
                'email',
            ])
        ]);
    }
    public function update(FormUpdateUser $request)
    {
        $this->authService->updateUser($request->validated(), $request->user());

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
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $this->authService->forgetPassword($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'verify your email'
        ]);
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->passwordResetService->reset($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'password reset successfully.'
        ]);
    }
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $this->authService->updatePassword($request->validated(), $user);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);
    }
    public function resendTokenPassword(ResendAuthenticationCodeRequest $request)
    {
        $data = $request->validated();

        $this->passwordResetService->resend($data);

        return response()->json([
            'success' => true,
            'message' => 'Authentication token has been sent to your email.'
        ]);
    }
    public function resendTwoFactor(ResendAuthenticationCodeRequest $request)
    {
        $data = $request->validated();

        $this->twoFactorService->resend($data);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication code has been sent to your email.'
        ]);
    }
}

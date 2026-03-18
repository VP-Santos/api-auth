<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Domains\Auth\Http\Requests\{
    FormForgotPasswordRequest,
    FormLoginRequest,
    FormRegisterUsers,
    FormResendAuthenticationCodeRequest,
    FormResetPasswordRequest,
    FormVerifyTokenEmailRequest,
    FormVerifyTwoFactorRequest,
};
use App\Domains\Auth\Services\{
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

    public function register(FormRegisterUsers $request)
    {
        $this->authService->registerUser($request->validated());

        return response()->json([
            'success'   => true,
            'message'  => 'Account created. Please check your email for verification.',
        ], 201);
    }

    public function verifyEmail(FormVerifyTokenEmailRequest $request)
    {
        $request->validated();
        $token = $request['token'];

        $tokenCreated = $this->emailVerificationService->verify($token);

        return response()->json([
            'success' => true,
            'message' => 'Email verification completed.',
            'token' => $tokenCreated
        ]);
    }

    public function login(FormLoginRequest $request)
    {
        $this->authService->login($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your email.',
        ]);
    }

    public function verifyTwoFactor(FormVerifyTwoFactorRequest $request)
    {
        $response = $this->twoFactorService->verify($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token' => $response,
        ]);
    }

    public function logout()
    {
        $user = request()->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ]);
    }

    public function forgotPassword(FormForgotPasswordRequest $request)
    {

        $this->authService->forgetPassword($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Password reset email sent. Please check your inbox.'
        ]);
    }
    public function resetPassword(FormResetPasswordRequest $request)
    {
        $this->passwordResetService->verify($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully.'
        ]);
    }
    public function resendTokenPassword(FormResendAuthenticationCodeRequest $request)
    {
        $data = $request->validated();

        $this->passwordResetService->resend($data);

        return response()->json([
            'success' => true,
            'message' => 'Password reset token sent to your email.'
        ]);
    }
    public function resendTwoFactor(FormResendAuthenticationCodeRequest $request)
    {
        $data = $request->validated();

        $this->twoFactorService->resend($data);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication code sent to your email.'
        ]);
    }
}

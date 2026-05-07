<?php

namespace App\Domains\Auth\Http\Controllers;

use App\Domains\Auth\Http\Requests\{
    FormEmailRequest,
    FormLoginRequest,
    FormRegisterUsers,
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

use App\Traits\ApiResponse;

class AuthController
{
    use ApiResponse;

    public function __construct(
        private AuthService $authService,
        private EmailVerificationService $emailVerificationService,
        private TwoFactorService $twoFactorService,
        private PasswordResetService $passwordResetService
    ) {}

    public function register(FormRegisterUsers $request)
    {
        $this->authService->registerUser($request->validated());

        return $this->success(
            'Account created. Please check your email for verification.',
            [],
            201
        );
    }

    public function verifyEmail(FormVerifyTokenEmailRequest $request)
    {
        $token = $request->validated()['token'];

        $this->emailVerificationService->verify($token);

        return $this->success(
            'Email verification completed.'
        );
    }

    public function login(FormLoginRequest $request)
    {
        $this->authService->login($request->validated());

        return $this->success(
            'Verification code sent to your email.'
        );
    }

    public function verifyTwoFactor(FormVerifyTwoFactorRequest $request)
    {
        $access_token = $this->twoFactorService->verify(
            $request->validated()
        );

        return $this->success(
            'Login successful.',
            [
                'access_token' => $access_token
            ]
        );
    }

    public function resendTwoFactor(FormEmailRequest $request)
    {
        $this->twoFactorService->resend(
            $request->validated()
        );

        return $this->success(
            'Two-factor authentication code sent to your email.'
        );
    }

    public function forgotPassword(FormEmailRequest $request)
    {
        $this->authService->forgetPassword(
            $request->validated()
        );

        return $this->success(
            'Password reset email sent. Please check your inbox.'
        );
    }

    public function resetPassword(FormResetPasswordRequest $request)
    {
        $this->passwordResetService->verify(
            $request->validated()
        );

        return $this->success(
            'Password has been reset successfully.'
        );
    }

    public function resendTokenPassword(FormEmailRequest $request)
    {
        $this->passwordResetService->resend(
            $request->validated()
        );

        return $this->success(
            'Password reset token sent to your email.'
        );
    }

    public function logout()
    {
        request()
            ->user()
            ->currentAccessToken()
            ->delete();

        return $this->success(
            'Logged out successfully.'
        );
    }
}
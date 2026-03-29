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
        $token = $this->authService->registerUser($request->validated());

        return response()->json([
            'success'   => true,
            'message'   => 'Account created. Please check your email for verification.',
            'token'     => $token,
        ], 201);
    }
    public function verifyEmail(FormVerifyTokenEmailRequest $request)
    {
        $request->validated();
        $token = $request['token'];

        $tokenCreated = $this->emailVerificationService->verify($token);

        return response()->json([
            'success'           => true,
            'message'           => 'Email verification completed.',
            'access_token'      => $tokenCreated
        ]);
    }
    public function resendVerifyEmail(FormEmailRequest $request)
    {
        $request->validated();
        $token = $request['token'];

        $tokenCreated = $this->emailVerificationService->verify($token);

        return response()->json([
            'success'           => true,
            'message'           => 'Email verification completed.',
            'access_token'      => $tokenCreated
        ]);
    }

    public function login(FormLoginRequest $request)
    {
        $code = $this->authService->login($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your email.',
            'code'    => $code,
        ]);
    }

    public function verifyTwoFactor(FormVerifyTwoFactorRequest $request)
    {
        $access_token = $this->twoFactorService->verify($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'access_token' => $access_token,
        ]);
    }

    public function resendTwoFactor(FormEmailRequest $request)
    {
        $data = $request->validated();

        $code = $this->twoFactorService->resend($data);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication code sent to your email.',
            'code'    => $code,
        ]);
    }

    public function forgotPassword(FormEmailRequest $request)
    {

        $token = $this->authService->forgetPassword($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Password reset email sent. Please check your inbox.',
            'token'   => $token,
        ]);
    }

    public function resetPassword(FormResetPasswordRequest $request)
    {
        $this->passwordResetService->verify($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully.',
        ]);
    }

    public function resendTokenPassword(FormEmailRequest $request)
    {
        $data = $request->validated();

        $token = $this->passwordResetService->resend($data);

        return response()->json([
            'success' => true,
            'message' => 'Password reset token sent to your email.',
            'token'   => $token,
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
}

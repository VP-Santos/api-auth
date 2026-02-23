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
    public function register(FormStoreUsers $request, AuthService $service)
    {
            $service->registerUser($request->validated());

            return response()->json([
                'success'   => true,
                'message'  => 'Account created. Please verify your email.',
            ], 201);
    }

    public function verifyEmail(Request $request)
    {
        try {
            $token = $request->query('token', null);

            if (!$token) {
                throw new \Exception('the token not found', 400);
            }

            DB::transaction(function () use ($token, &$tokenCreated) {

                $record = DB::table('email_verifications')->where('token', $token)->first();

                if (!$record || $record->expires_at < now()) {
                    throw new \App\Exceptions\Auth\InvalidTokenException();
                }

                $user = User::findOrFail($record->user_id);
                $user->email_verified_at = now();
                $user->status = 'actived';

                $abilities = [$user->access_level];
                $tokenCreated = $user->createToken('access', $abilities)->plainTextToken;
                $user->current_token = $tokenCreated;
                $user->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'E-mail verificado com sucesso',
                'token' => $tokenCreated
            ]);
        } catch (\Throwable $e) {
            $status = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $status);
        }
    }

    public function login(FormLoginRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $user = User::where('email', $request->email)->first();

                if (!$user || !Hash::check($request->password, $user->password)) {
                    throw new \Exception('The credentials provided are incorrect.');
                }

                if (!$user->email_verified_at) {
                    throw new \Exception('Email not yet verified');
                }

                $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

                TwoFactor::create([
                    'user_id' => $user->id,
                    'code' => $code,
                    'expires_at' => now()->addMinutes(2),
                ]);

                DB::afterCommit(function () use ($user, $code) {
                    Mail::to($user->email)->send(new TwoFactorVerify($code));
                });
            });

            return response()->json([
                'success' => true,
                'message' => 'codigo enviado ao email',
            ], 200);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }


    public function verifyTwoFactor(VerifyTwoFactorRequest $request)
    {
        try {
            $fields = $request->validated();

            if (!$fields['email'] || !$fields['code']) {
                throw new \Exception('email e código obrigatórios', 400);
            }

            $user = User::where('email', '=', $fields['email'])->firstOrFail();

            $twoFactor = TwoFactor::where('user_id', '=', $user->id)->firstOrFail();

            if (now() > $twoFactor->expires_at || !hash_equals($twoFactor->code, $fields['code'])) {
                throw new \App\Exceptions\Auth\InvalidTwoFactorCodeException();
            }

            $abilities = [$user->access_level];
            $token = $user->createToken('access', $abilities)->plainTextToken;
            $user->current_token = $token;
            $user->save();


            return response()->json([
                'success' => true,
                'message' => 'login aceito',
                'user_id' => $user->id,
                'token' => $token,
            ], 200);
        } catch (\Throwable $e) {
            $status = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $status);
        }
    }

    public function show()
    {
        try {

            $user = request()->user();

            if (!$user) {
                return response()->json(['message' => 'Não autenticado'], 401);
            }

            return response()->json([
                'token'  => $user['current_token'],
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
        try {

            $userData = $request->validated();

            $user = $request->user();


            $user->update($userData);

            return [
                'user' => $user
            ];
        } catch (\Throwable $e) {
        }
    }
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            $user->currentAccessToken()->delete();

            return response()->json(['info' => 'usuario deslogado'], 200);
        } catch (\Throwable $e) {
        }
    }

    public function resetPassword()
    {
        try {
        } catch (\Throwable $e) {
        }
    }

    public function generateToken()
    {
        try {
        } catch (\Throwable $e) {
        }
    }
}

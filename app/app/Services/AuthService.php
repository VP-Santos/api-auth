<?php

namespace App\App\Services;

use App\Mail\{
    TwoFactorVerify,
    VerifyEmailMail
};
use App\Models\{
    User,
    EmailVerification,
    TwoFactor
};

use Illuminate\Support\Facades\{
    DB,
    Hash,
    Mail,
    Log
};

use Exception;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function registerUser(array $data)
    {
        DB::transaction(function () use ($data) {
            //validação dos campos
            $userData = $data;

            //criando dados do usuario
            $userData['password'] = Hash::make($userData['password']);
            $userData['email_verified_at'] = null;

            //criando o usuario na tabela
            $user = User::create($userData);

            //codigo de verificação de email
            $verificationToken = Str::random(64);

            //table de hash do codigo
            EmailVerification::created([
                'user_id' => $user->id,
                'token' => $verificationToken,
                'expires_at' => now()->addMinutes(30),
            ]);

            //enviando email de validação
            DB::afterCommit(function () use ($user, $verificationToken) {
                Mail::to($user->email)
                    ->send(new VerifyEmailMail($verificationToken));
            });
        });

        return true;
    }

    public function verifyEmailToken() {}
    public function authenticateStepOne($data) {
          DB::transaction(function () use ($data) {

                $user = User::where('email', $data->email)->first();

                if (!$user->email_verified_at) {
                    throw new Exception('Email not yet verified');
                }

                if (!$user || ! Hash::check($data->password, $user->password)) {
                    throw new Exception('The credentials provided are incorrect.');
                }

                $code = mt_rand(000000, 999999);

                TwoFactor::created([
                    'user_id' => $user->id,
                    'code' => $code,
                    'expires_at' => now()->addMinutes(2),

                ]);

                DB::afterCommit(function () use ($user, $code) {
                    Mail::to($user->email)->send(new TwoFactorVerify($code));
                });
            });
    }
    public function verifyTwoFactor() {}
}

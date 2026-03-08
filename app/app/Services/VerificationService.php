<?php
?><?php

    namespace App\Services;

    use App\Exceptions\Auth\{
        InvalidTokenException,
        InvalidTwoFactorCodeException,
        SameEmailException,
        SamePasswordException,
        VerificationCodeAlreadySentException
    };
    use App\Models\{
        EmailVerification,
        PasswordReset,
        TwoFactor,
        User
    };
    use Illuminate\Support\Facades\{
        DB,
        Hash
    };

    class VerificationService
    {
        public function verifyTokenEmail(string $token)
        {
            $tokenCreated = null;

            DB::transaction(function () use ($token, &$tokenCreated) {

                $record = EmailVerification::where('token', $token)->first();

                if (!$record) {
                    throw new InvalidTokenException('Token is invalid or has already been used.');
                }

                if ($record->expires_at < now()) {
                    throw new InvalidTokenException('Token has expired.');
                }

                $user = User::findOrFail($record->user_id);

                if ($user->email_verified_at) {
                    throw new InvalidTokenException('Email has already been verified.', 409);
                }

                $user->email_verified_at = now();
                $user->status = 'actived';

                $abilities = [$user->access_level];
                $tokenCreated = $user->createToken('access', $abilities)->plainTextToken;
                $user->current_token = $tokenCreated;
                $user->save();

                $record->delete();
            });

            return $tokenCreated;
        }
        public function verifyTwoFactor(array $data)
        {

            $user = User::where('email', '=', $data['email'])
                ->first();

            $twoFactor = TwoFactor::where('user_id', '=', $user->id)
                ->orderBy('created_at', 'DESC')->first();

            if (!$twoFactor) {
                throw new InvalidTwoFactorCodeException;
            }

            if (now() > $twoFactor->expires_at || !hash_equals($twoFactor->code, $data['code'])) {
                throw new InvalidTwoFactorCodeException;
            }

            $abilities = [$user->access_level];
            $token = $user->createToken('access', $abilities)->plainTextToken;
            $user->current_token = $token;
            $user->save();

            $twoFactor->where('user_id', '=', $user->id)->delete();
            return [
                'token' => $token
            ];
        }
        public function verifyResetPassword(array $data)
        {
            DB::transaction(function () use ($data) {

                $user = User::where('email', '=', $data['email'])->first();

                $token = $data['token'];

                $record = PasswordReset::where('token', '=', $token)->first();

                if ($user->email != $data['email']) {
                    throw new SameEmailException;
                }

                if (!$record) {
                    throw new InvalidTokenException('Token not found.');
                }

                if ($record->expires_at < now()) {
                    throw new InvalidTokenException('Token has expired.');
                }

                $data['password'] = Hash::make($data['password']);

                if (!Hash::check($data['password'], $user->password)) {
                    throw new SamePasswordException;
                }

                $user->update(['password' => $data['password']]);

                $record->delete();
            });
        }

        public function getTokenExists($user_id)
        {
            $token = PasswordReset::where('user_id', '=', $user_id)
                ->latest()
                ->first();

            if ($token) {
                if ($token->expires_at > now()) {

                    $secondsRemaining = now()->diffInSeconds($token->expires_at);

                    $time = gmdate('i:s', $secondsRemaining);
                    throw new VerificationCodeAlreadySentException(
                        "Verification code already sent. Please wait {$time} seconds before requesting a new one."
                    );
                }

                $token->delete();
            }
        }
        public function getTwoFactorExists($user_id)
        {
            $twoFactor = TwoFactor::where('user_id', '=', $user_id)
                ->first();

            if ($twoFactor) {
                if ($twoFactor->expires_at > now()) {

                    $secondsRemaining = now()->diffInSeconds($twoFactor->expires_at);

                    $time = gmdate('i:s', $secondsRemaining);
                    throw new VerificationCodeAlreadySentException(
                        "Verification code already sent. Please wait {$time} seconds before requesting a new one."
                    );
                }

                $twoFactor->delete();
            }
        }
    }

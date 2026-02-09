<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Users\{
    FormLoginRequest,
    FormStoreUsers,
    FormUpdateUser
};
use App\Mail\{TwoFactorVerify, VerifyEmailMail};
use App\Models\EmailVerification;
use App\Models\TwoFactor;
use Illuminate\Support\Facades\{DB, Hash, Mail, Log};
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AuthController
{
    public function register(FormStoreUsers $request)
    {
        try {
            DB::transaction(function () use ($request) {
                //validação dos campos
                $userData = $request->validated();

                //criando dados do usuario
                $userData['password'] = Hash::make($userData['password']);
                $userData['email_verified_at'] = null;

                //criando o usuario na tabela
                $user = User::create($userData);

                //codigo de verificação de email
                $verificationToken = Str::random(64);

                //table de hash do codigo
                EmailVerification::create([
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

            return response()->json([
                'success'   => true,
                'message'  => 'Account created. Please verify your email.',
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {

            Log::error('Database error during registration', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Our database is currently unavailable. Please try again later.',
            ], 503);
        } catch (\Throwable $e) {

            Log::error('Unexpected registry error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error.',
            ], 500);
        }
    }
    public function login(FormLoginRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $user = User::where('email', $request->email)->first();

                if (!$user || !Hash::check($request->password, $user->password)) {
                    throw new Exception('The credentials provided are incorrect.');
                }

                if (!$user->email_verified_at) {
                    throw new Exception('Email not yet verified');
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
                'message' => 'codigo enviado ao email'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Login DB Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error searching the database.',
            ], 503);

        } catch (\Throwable $e) {
           
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    public function show(Request $request)
    {
        try {

            $user = $request->user();

            if (!$user) {
                return response()->json(['message' => 'Não autenticado'], 401);
            }

            return response()->json([
                'token'  => $user['current_token'],
                'credenciais' => $user
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching the database.',
            ], 500);
        } catch (Exception $e) {
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
        } catch (QueryException $e) {
        } catch (Exception $e) {
        }
    }
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            $user->currentAccessToken()->delete();

            return response()->json(['info' => 'usuario deslogado'], 200);
        } catch (QueryException $e) {
        } catch (Exception $e) {
        }
    }

    public function verifyEmail(Request $request)
    {
        try {

            $token = $request->query('token');
            $user = null;
            DB::transaction(function () use ($token, $user) {

                $record = DB::table('email_verifications')->where('token', $token)->first();

                if (!$record) {
                    return response()->json(['message' => 'Token inválido ou expirado'], 400);
                }
                if ($record->expires_at < now()) {
                    return response()->json(['message' => 'Token inválido ou expirado'], 400);
                }

                $user = User::find($record->user_id);
                $user->email_verified_at = now();
                $user->status = 'actived';
                $user->save();

                // gerar token de login agora que o e-mail foi verificado
                $abilities = [$user->access_level];
                $token = $user->createToken('access', $abilities)->plainTextToken;
                $user->current_token = $token;
                $user->save();
            });

            return response()->json([
                'message' => 'E-mail verificado com sucesso!',
                'token' => $token,
                'credenciais' => $user
            ], 200);
        } catch (QueryException $e) {
        } catch (Exception $e) {
        }
    }

    public function verifyTwoFactor(Request $request)
    {
        try {

            $email  = $request->input('email', false);
            $code   = $request->input('code', false);

            $user = DB::table('users')->where('email', '=', $email)->first();

            $twoFactor = DB::table('two_factor')->where('user_id', '=', $user->id)->first();

            if (now() > $twoFactor->expires_at) {
                throw new Exception('o tempo limite foi expirado');
            }

            if ($code != $twoFactor->code) {
                throw new Exception('codigo divergente');
            }

            $abilities = [$user->access_level];
            $token = $user->createToken('access', $abilities)->plainTextToken;
            $user->current_token = $token;
            $user->save();

            DB::table('two_factor')->where('user_id', '=', $user->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'login aceito',
                'token' => $token,
            ], 200);
        } catch (QueryException $e) {
        } catch (Exception $e) {
        }
    }

    public function resetPassword()
    {
        try {
        } catch (QueryException $e) {
        } catch (Exception $e) {
        }
    }

    public function generateToken()
    {
        try {
        } catch (QueryException $e) {
        } catch (Exception $e) {
        }
    }
}

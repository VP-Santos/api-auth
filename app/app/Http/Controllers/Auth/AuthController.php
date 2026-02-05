<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Users\FormLoginRequest;
use App\Http\Requests\Users\FormStoreUsers;
use App\Http\Requests\Users\FormUpdateUser;
use App\Mail\TwoFactorVerify;
use App\Mail\VerifyEmailMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function register(FormStoreUsers $request)
    {
        $userData = $request->validated();

        $userData['password'] = bcrypt($userData['password']);
        $userData['email_verified_at'] = null;

        $user = User::create($userData);

        $verificationToken = Str::random(64);

        DB::table('email_verifications')->insert([
            'user_id' => $user->id,
            'token' => $verificationToken,
            'created_at' => now(),
            'expires_at' => now()->addMinutes(30),
        ]);

        Mail::to($user->email)->send(new VerifyEmailMail($verificationToken));

        return response()->json([
            'message' => 'Conta criada! Verifique seu e-mail para ativar.',
        ], 201);
    }


    public function login(FormLoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user->email_verified_at) {
            throw ValidationException::withMessages([
                'error' => ['Email ainda não verificado']
            ]);
        }

        if (!$user || ! Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'error' => ['As credenciais fornecidas estão incorretas.']
            ]);
        }

        $code = mt_rand(000000, 999999);
        // dd($code);
        DB::table('two_factor')->insert([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(2),
        ]);

        Mail::to($user->email)->send(new TwoFactorVerify($code));

        return response()->json([
            'status' => 'success',
            'message' => 'codigo enviado ao email'
        ], 200);
    }

    public function show(Request $request)
    {

        $user = $request->user();

        if (!$user) {

            return response()->json(['message' => 'Não autenticado'], 401);
        }

        return response()->json([
            'token'  => $user['current_token'],
            'credenciais' => $user
        ], 200);
    }
    public function update(FormUpdateUser $request)
    {
        $userData = $request->validated();

        $user = $request->user();

        $user->update($userData);

        return [
            'user' => $user
        ];
    }
    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json(['info' => 'usuario deslogado'], 200);
    }
    public function verifyEmail(Request $request)
    {
        $token = $request->query('token');

        $record = DB::table('email_verifications')->where('token', $token)->first();

        if (!$record || $record->expires_at < now()) {
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

        return response()->json([
            'message' => 'E-mail verificado com sucesso!',
            'token' => $token,
            'credenciais' => $user
        ], 200);
    }

    public function verifyTwoFactor(Request $request)
    {
        try {

            $email  = $request->input('email', false);
            $code   = $request->input('code', false);

            $user = DB::table('users')->where('email', '=', $email)->first();

            $twoFactor = DB::table('two_factor')->where('user_id', '=', $user->id)->first();

            if (now() > $twoFactor->expires_at) {
                throw ValidationException::withMessages([
                    'error' => ['o tempo limite foi expirado']
                ]);
            }

            if ($code != $twoFactor->code) {
                throw ValidationException::withMessages([
                    'error' => ['codigo divergente']
                ]);
            }
            DB::table('two_factor')->where('user_id', '=', $user->id)->delete();
            
            return response()->json([
                'status' => 'sucess',
                'message' => 'login aceito'
            ], 200);
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}

<?php

namespace App\Domains\Users\Actions;

use App\Exceptions\BodyNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateMeAction
{
    public function execute(User $user, array $data): User
    {
        
        if (empty($data)) {
            throw new BodyNotFoundException();
        }
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->fill($data);
        $user->save();

        return $user;
    }
}

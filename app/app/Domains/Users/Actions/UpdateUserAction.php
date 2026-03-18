<?php

namespace App\Domains\Users\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function execute(User $user, array $data): User
    {   
        if($data['password']){
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->fill($data);
        $user->save();

        return $user;
    }
}

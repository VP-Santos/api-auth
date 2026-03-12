<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class BanUserAction
{
    public function execute(User $user): User
    {
        $user->is_banned = true;
        $user->save();

        return $user;
    }
}
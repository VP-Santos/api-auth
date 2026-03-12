<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class BanUserAction
{
    public function execute(int $id): ?User
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        $user->is_banned = true;
        $user->save();

        return $user;
    }
}
<?php

namespace App\Domains\Users\Actions;

use App\Models\User;

class DeleteUserAction
{
    public function execute(User $user): bool
    {
        $user_name = $user->name;
        $user->delete();
        return $user_name;
    }
}

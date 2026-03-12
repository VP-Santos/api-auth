<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class PromoteUserAction
{
    public function execute(User $user, string $newRole): User
    {
        $user->role = $newRole;
        $user->save();

        return $user;
    }
}
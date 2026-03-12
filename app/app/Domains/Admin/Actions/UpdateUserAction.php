<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class UpdateUserAction
{
    public function execute(User $user, array $data): User
    {
        $user->update($data);

        return $user;
    }
}
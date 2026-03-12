<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class UpdateUserAction
{
    public function execute(int $id, array $data): ?User
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        $user->update($data);

        return $user;
    }
}
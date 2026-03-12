<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class PromoteUserAction
{
    public function execute(int $id, string $newRole): ?User
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        $user->role = $newRole;
        $user->save();

        return $user;
    }
}
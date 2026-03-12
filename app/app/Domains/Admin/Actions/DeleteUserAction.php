<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class DeleteUserAction
{
    public function execute(int $id): bool
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }
}
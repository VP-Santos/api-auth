<?php

namespace App\Domains\Users\Actions;

use App\Models\User;

class DeleteMeAction
{
    public function execute(User $user): string
    {
        $user_name = $user->name;
        $user->delete();
        return $user_name;
    }
}

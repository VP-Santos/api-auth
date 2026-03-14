<?php

namespace App\Domains\Users\Actions;

use App\Models\User;

class ShowProfileAction
{
    public function execute(User $user): User
    {
        return $user;
    }
}

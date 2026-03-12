<?php

namespace App\Domains\Auth\Actions;

use App\Models\User;

class ShowProfileAction
{
    public function execute(User $user): User
    {
        return $user;
    }
}

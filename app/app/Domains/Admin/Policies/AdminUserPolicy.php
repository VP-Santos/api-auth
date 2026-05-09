<?php

namespace App\Domains\Admin\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminUserPolicy
{
    public function thisAction(User $user, User $targetUser): bool
    {
        return $user->id != $targetUser->id;
    }
}

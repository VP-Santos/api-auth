<?php

namespace App\Domains\Users\Actions;

use App\Models\User;

class ShowMeAction
{
    public function execute(User $user): array 
    {
        return $user->only([
                'id',
                'name',
                'email',
            ]);
    }
}

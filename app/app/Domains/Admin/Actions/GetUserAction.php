<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class GetUserAction
{
    public function execute(int $id): ?User
    {
        return User::find($id);
    }
}
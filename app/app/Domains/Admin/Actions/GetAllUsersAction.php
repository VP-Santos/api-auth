<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;

class GetAllUsersAction
{
    public function execute()
    {
        return User::all();
    }
}
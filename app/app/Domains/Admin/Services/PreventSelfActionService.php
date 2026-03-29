<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Exceptions\CannotPerformActionOnYourselfException;
use App\Models\User;
use Illuminate\Http\Request;

class PreventSelfActionService
{

    /**
     * Summary of check
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return void
     */
    public function check(User  $user, int $id)
    {
        if ($user->id == $id) {
            throw new CannotPerformActionOnYourselfException;
        }
    }
}

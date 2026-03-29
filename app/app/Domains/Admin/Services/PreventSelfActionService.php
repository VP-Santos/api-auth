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
    public function check(Request $request, User $user) {

        if($request->user() && $request->user()->id == $user->id){
           throw new CannotPerformActionOnYourselfException;
        }
    }    
}

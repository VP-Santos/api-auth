<?php

namespace App\Domains\Admin\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Domains\Admin\Policies\AdminUserPolicy;

class AdminProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(User::class, AdminUserPolicy::class);
    }
}

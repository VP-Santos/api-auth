<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;
use App\Repositories\UserRepository;

class BanUserAction
{
    public function __construct(
        protected UserRepository $repository
    ) {}

    public function execute(User $user)
    {
        $data = [
            'is_banned' => true
        ];

        return $this->repository->update($user, $data);
    }
}

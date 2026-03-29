<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function __construct(
        protected UserRepository $repository,
    ) {}
    public function execute(int $id, array $data): User
    {
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->repository->update($id, $data);
        
        return $user;
    }
}

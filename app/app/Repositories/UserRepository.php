<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use App\Domains\Admin\Exceptions\UserNotFoundException;
use App\Models\User;

class UserRepository implements RepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }


    public function all()
    {
        return $this->model->all();
    }

    public function findOrFail(int $id): User
    {
        $user = $this->model->find($id);
        
        if(!$user){
            throw new UserNotFoundException($id);
        }
        return $user;
    }

    public function updateById(int $id, array $data): User
    {
        $user = $this->findOrFail($id);
        $user->update($data);

        return $user->refresh();
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user->refresh();
    }

    public function delete(User $user): User
    {
        $user->delete();

        return $user;
    }
}

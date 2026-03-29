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

    public function find(int $id): ?User
    {
        $user = $this->model->find($id);

        return $user;
    }

    public function update(int $id, array $data): User
    {
        $user = $this->find($id);
        $user->update($data);

        return $user->refresh();
    }

    public function delete(int $id): User
    {
        $user = $this->find($id);

        $user->delete();

        return $user->id;
    }
}

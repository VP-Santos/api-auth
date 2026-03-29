<?php

namespace App\Domains\Admin\Repositories;

use App\Contracts\RepositoryInterface;
use App\Domains\Admin\Exceptions\UserNotFoundException;
use App\Models\User;

class AdminRepository implements RepositoryInterface
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
        
        if(!$user){
            throw new UserNotFoundException($id);
        };
        return $user; 
    }
    
    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);
        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
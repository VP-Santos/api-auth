<?php 

namespace App\Contracts;

use App\Models\User;

interface RepositoryInterface
{
    public function all();

    public function findOrFail(int $id);

    public function update(User $user, array $data);

    public function delete(User $user);
}
<?php 

namespace App\Contracts;

interface RepositoryInterface
{
    public function all();

    public function find(int $id);

    public function update(int $id, array $data);

    public function delete(int $id);
}
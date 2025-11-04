<?php

namespace App\Repositories;

class AbstractRepository
{   
    protected $model;
    
    public function create(array $data)
    {
        return $this->model::create($data);
    }
}

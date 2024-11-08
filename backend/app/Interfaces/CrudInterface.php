<?php

namespace App\Interfaces;

interface CrudInterface
{
    
    public function getAll();

    
    public function getPaginatedData(int $perPage);

    
    public function create(array $data);

    
    public function delete(int $id);

    
    public function getByID(int $id);

    
    public function update(int $id, array $data);
}

<?php

namespace App\Repositories\Interfaces;

interface CategoryInterface
{
    public function getAll();
    public function find($id);
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
    );
    public function create(array $payload = []);
    public function update(int $id = 0, array $payload = []);
    public function delete(int $id = 0);
    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    );
    // Add other interface methods as needed
}
<?php

namespace App\Repositories\Interfaces;

interface ReviewInterface
{
    public function getAll();
    public function find($id);
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
        array $trashed=[]
    );
    public function delete(int $id = 0);
    // cập nhật trạng thái
    public function update(int $id = 0, array $payload = []);
    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    );
}
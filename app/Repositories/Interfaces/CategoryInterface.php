<?php
namespace App\Repositories\Interfaces;

interface CategoryInterface
{
    public function getAll();
    public function find($id);
    public function pagination($columns, $condition, $perPage);
    public function create(array $payload = []);
    public function update(int $id = 0, array $payload = []);
    public function delete(int $id = 0);

    // Add other interface methods as needed
}
<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserCatalogueRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface UserCatalogueRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function create(array $payload = []);
    public function update(int $id = 0, array $payload = []);
    public function delete(int $id = 0);
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
    );
    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    );
}

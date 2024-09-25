<?php

namespace App\Repositories;

use App\Models\Province;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;

/**
 * Class ProvinceRepository
 * @package App\Repositories
 */
class ProvinceRepository implements ProvinceRepositoryInterface
{
    protected $model;
    public function __construct(Province $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model->all();
    }

    public function findById(
        int $modelId,
        array $column = ['*'],
        array $relation = []
    ) {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }



}

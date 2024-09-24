<?php

namespace App\Repositories;

use App\Models\District;
use App\Repositories\Interfaces\DistrictRepositoryInterface;

/**
 * Class DistrictRepository
 * @package App\Repositories
 */
class DistrictRepository implements DistrictRepositoryInterface
{
    protected $model;

    public function __construct(District $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model->all();
    }

    public function findDistrictByProvinceId(int $province_id = 0) {
        return $this->model->where('province_code', '=', $province_id)->get();
    }

    public function findById(
        int $modelId,
        array $column = ['*'],
        array $relation = []
    ) {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

    public function create(array $payload = []) {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    public function update(int $id = 0, array $payload = []) {
        $model = $this->findById($id);
        return $model->update($payload);
    }
}

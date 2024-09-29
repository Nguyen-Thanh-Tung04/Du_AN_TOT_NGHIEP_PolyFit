<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Faker\Provider\Base;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository
{

    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
    ) {
        $query = Product::select($column)
            ->where(function($query) use ($condition) {
                if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                    $query->where('name', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('code', 'LIKE', '%'.$condition['keyword'].'%');
                }
                if (isset($condition['status']) && $condition['status'] == 1) {
                    $query->where('status', '=', '1');
                } elseif (isset($condition['status']) && $condition['status'] == 2) {
                    $query->where('status', '=', '2');
                }
                return $query;
            })->with('categories');

            return $query->paginate($perpage)
            ->withQueryString()->withPath(config('app.url').$extend['path']);
    }

    public function create(array $payload = []) {
        $model = Product::create($payload);
        return $model->fresh();
    }

    public function update(int $id = 0, array $payload = []) {
        $model = $this->findById($id);
        return $model->update($payload);
    }

    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    ) {
        return Product::whereIn($whereInField, $whereIn)->update($payload);
    }

    public function delete(int $id = 0) {
        return $this->findById($id)->delete();
    }

    // public function forceDelete(int $id = 0) {
    //     return $this->findById($id)->forceDelete();
    // }

    public function all() {
        return Product::all();
    }

    public function dropdown() {
        Category::all();
    }

    public function findById($id) {
        return Product::findOrFail($id);
    }

}

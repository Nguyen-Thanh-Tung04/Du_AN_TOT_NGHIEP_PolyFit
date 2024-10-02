<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Faker\Provider\Base;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository
{
    public function getAttr(string $table, array $column = ['*']){
        return $table::select($column)->get();
    }
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $orderBy = [],
        array $join = [],
        array $extend = [],
    ) {
        $query = Product::select($column)
            ->where(function($query) use ($condition) {
                if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                    $query->where('products.name', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('products.code', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('categories.name', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('products.description', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('products.status', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('products.category_id', 'LIKE', '%'.$condition['keyword'].'%');
                }
                if (isset($condition['status']) && $condition['status'] == 1) {
                    $query->where('status', '=', '1');
                } elseif (isset($condition['status']) && $condition['status'] == 2) {
                    $query->where('status', '=', '2');
                }
                // return $query;
            })->with('categories');

            if(isset($orderBy) && !empty($orderBy)) {
                $query->orderBy($orderBy[0], $orderBy[1]);
            }

            if(isset($join) && is_array($join) && count($join)) {
                foreach($join as $key => $val) {
                    $query->join($val[0], $val[1], $val[2], $val[3]);
                }
            }

            return $query->paginate($perpage)
            ->withQueryString()->withPath(config('app.url').$extend['path']);
    }

    public function create(array $payload = []) {
        $model = Product::create($payload);
        return $model->fresh();
    }

    public function variantCreate(array $payload = []) {
        $model = Variant::create($payload);
        return $model->fresh();
    }

    public function update(int $id = 0, array $payload = []) {
        $model = $this->findById($id);
        return $model->update($payload);
    }

    public function variantUpdate(int $id = 0, array $payload = []) {
        $model = Variant::findOrFail($id);
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
    public function deleteVariantById(string $id, array $arrVariantIds = []) {
        return Variant::whereIn($id, $arrVariantIds)->delete();
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
        return Product::with('variants')->findOrFail($id);
    }

}

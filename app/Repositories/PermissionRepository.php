<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Variant;
use Faker\Provider\Base;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository
{
    public function getAttr(string $table, array $column = ['*']){
        return $table::select($column)->get();
    }
    public function getSearchAttr(string $table, array $column = ['*']){
        return $table::select($column)->get()->toArray();
    }
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $orderBy = [],
        array $join = [],
        array $extend = [],
    ) {
        $query = Permission::select($column)
            ->where(function($query) use ($condition) {
                if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                    $query->where('permissions.name', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('permissions.canonical', 'LIKE', '%'.$condition['keyword'].'%');
                }
            });

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
        $model = Permission::create($payload);
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
        return Permission::whereIn($whereInField, $whereIn)->update($payload);
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
        return Permission::all();
    }

    public function dropdown() {
        Category::all();
    }

    public function findById($id) {
        return Permission::findOrFail($id);
    }

}

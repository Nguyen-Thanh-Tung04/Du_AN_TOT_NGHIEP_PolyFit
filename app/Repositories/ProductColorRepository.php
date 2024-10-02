<?php

namespace App\Repositories;

use App\Models\Color;
use Faker\Provider\Base;

/**
 * Class ColorRepository
 * @package App\Repositories
 */
class ProductColorRepository
{
    public function getAttr(string $table, array $column = ['*']){
        return $table::select($column)->get();
    }
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $orderBy = ['id', 'DESC'],
        array $join = [],
        array $extend = [],
    ) {
        $query = Color::select($column)
            ->where(function($query) use ($condition) {
                if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                    $query->where('name', 'LIKE', '%'.$condition['keyword'].'%');
                }
                // return $query;
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
        $model = Color::create($payload);
        return $model->fresh();
    }


    public function update(int $id = 0, array $payload = []) {
        $model = Color::findOrFail($id);
        return $model->update($payload);
    }


    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    ) {
        return Color::whereIn($whereInField, $whereIn)->update($payload);
    }

    public function delete(int $id = 0) {
        return $this->findById($id)->delete();
    }

    // public function forceDelete(int $id = 0) {
    //     return $this->findById($id)->forceDelete();
    // }

    public function all() {
        return Color::all();
    }


    public function findById($id) {
        return Color::findOrFail($id);
    }

}

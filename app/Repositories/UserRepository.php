<?php

namespace App\Repositories;

use App\Models\User;
use Faker\Provider\Base;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    public function getCatalogue(string $table, array $column = ['*']){
        return $table::select($column)->get();
    }

    public function pagination(
        array $column = ['*'],
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
    ) {
        $query = User::select($column)
            ->where(function($query) use ($condition) {
                if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                    $query->where('name', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('email', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('phone', 'LIKE', '%'.$condition['keyword'].'%')
                    ->orWhere('address', 'LIKE', '%'.$condition['keyword'].'%');
                }
                if (isset($condition['publish']) && $condition['publish'] == 1) {
                    $query->where('publish', '=', '1');
                } elseif (isset($condition['publish']) && $condition['publish'] == 2) {
                    $query->where('publish', '=', '2');
                }
                $query->where('user_catalogue_id', '>', 0);
                return $query;
            })->with('user_catalogues');

            return $query->paginate($perpage)
            ->withQueryString()->withPath(config('app.url').$extend['path']);
    }

    public function create(array $payload = []) {
        $model = User::create($payload);
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
        return User::whereIn($whereInField, $whereIn)->update($payload);
    }

    public function delete(int $id = 0) {
        return $this->findById($id)->delete();
    }

    // public function forceDelete(int $id = 0) {
    //     return $this->findById($id)->forceDelete();
    // }

    public function all() {
        return User::all();
    }

    public function findById($id) {
        return User::findOrFail($id);
    }

}

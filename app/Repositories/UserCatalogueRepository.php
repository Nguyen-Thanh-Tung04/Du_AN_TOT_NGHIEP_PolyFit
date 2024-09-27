<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserCatalogue;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface;
use Faker\Provider\Base;
use Illuminate\Support\Facades\DB;

/**
 * Class UserCatalogueRepository
 * @package App\Repositories
 */
class UserCatalogueRepository implements UserCatalogueRepositoryInterface
{
    public function pagination(
        array $column = ['*'], 
        array $condition = [],
        int $perpage = 1,
        array $extend = [],
    ) {
        $query = UserCatalogue::select($column)
            ->withCount('users')
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
                return $query;
            });

            return $query->paginate($perpage)
            ->withQueryString()->withPath(config('app.url').$extend['path']);
    }

    public function create(array $payload = []) {
        return UserCatalogue::create($payload);
    }

    public function update(int $id = 0, array $payload = []) {
        $userCatalogue = UserCatalogue::findOrFail($id);
        $userCatalogue->update($payload);
        return $userCatalogue;
    }

    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    ) {
        return UserCatalogue::whereIn($whereInField, $whereIn)->update($payload);
    }

    public function delete(int $id = 0) {
        $userCatalogue = UserCatalogue::findOrFail($id);
        return $userCatalogue->delete();
    }

    // public function forceDelete(int $id = 0) {
    //     return $this->findById($id)->forceDelete();
    // }

    public function all() {
        return UserCatalogue::all();
    }

    public function findById(int $id) {
        return UserCatalogue::findOrFail($id);
    }

}

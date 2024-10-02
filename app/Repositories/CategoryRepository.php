<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryInterface;
use App\Models\Category;


class CategoryRepository implements CategoryInterface
{
    public function getAll()
    {
        // Implement logic to get all categories
        return Category::all();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function pagination(
        array $columns = ['*'],
        array $conditions = [],
        int $perPage = 10,
        array $extend = []
    ) {
        $query = Category::query();
    
        // Thêm điều kiện tìm kiếm vào query
        if (!empty($conditions['keyword'])) {
            $query->where(function ($q) use ($conditions) {
                $q->where('name', 'like', '%' . $conditions['keyword'] . '%')
                    ->orWhere('code', 'like', '%' . $conditions['keyword'] . '%');
            });
        }
    
        // Thêm điều kiện isActive vào query nếu được chọn
        if (isset($conditions['is_active'])) {
            $query->where('is_active', $conditions['is_active']);
        }
    
        // Thêm điều kiện lọc và tìm kiếm cùng lúc
        if (!empty($conditions['keyword']) && isset($conditions['is_active'])) {
            $result = $query->where('is_active', $conditions['is_active'])
                            ->where(function ($q) use ($conditions) {
                                $q->where('name', 'like', '%' . $conditions['keyword'] . '%')
                                    ->orWhere('code', 'like', '%' . $conditions['keyword'] . '%');
                            })
                            ->paginate($perPage, $columns);
        } else {
            // Thực hiện paginate và trả về kết quả
            $result = $query->paginate($perPage, $columns);
        }
    
        return $result;
    }
    public function create(array $data = [], array $payload = [])
    {
        $model = Category::create(array_merge($data, $payload));
        return $model->fresh();
    }

    public function update(int $id = 0, array $payload = [])
    {
        $categoryService = Category::findOrFail($id);
        $categoryService->update($payload);
        return $categoryService;
    }
    public function delete(int $id = 0)
    {
        $userCatalogue = Category::findOrFail($id);
        return $userCatalogue->delete();
    }

    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    ) {
        return Category::whereIn($whereInField, $whereIn)->update($payload);
    }
    // Implement other methods as needed
}
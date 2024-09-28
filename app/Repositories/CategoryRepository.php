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

    public function pagination($columns, $condition, $perPage)
    {
        return Category::all();
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

    // Implement other methods as needed
}
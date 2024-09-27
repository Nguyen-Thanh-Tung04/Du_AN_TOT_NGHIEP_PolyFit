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
        // Implement logic to find a category by ID
    }

    public function pagination($columns, $condition, $perPage)
    {
        return Category::all();
    }

    // Implement other methods as needed
}
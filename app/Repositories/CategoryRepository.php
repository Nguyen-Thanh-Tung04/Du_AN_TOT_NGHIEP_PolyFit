<?php

namespace App\Repositories;

use App\Models\Category;
use Faker\Provider\Base;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{

    // Viết truy vấn hiển thị danh sách, $column là các trường muốn hiển thị, mặc định là '*'
    public function pagination(
        array $column = ['*'],
    ) {
        $query = Category::select($column);
        return $query;
    }
}

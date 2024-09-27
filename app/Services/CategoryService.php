<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    // Nhận thông tin request bên controller, dd($request) để xem, truyền tham số thứ nhất vào pagination() là 3 trường trong db
    public function paginate($request) {
        $categories = $this->categoryRepository->pagination([
            'id',
            'name',
            'publish',
        ]);
        return $categories;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Services\CategoryService;
use App\Repositories\CategoryRepository;

class CategoryController
{
    protected $categoryService;
    protected $categoryRepository;

    public function __construct(
        CategoryService $categoryService, 
        CategoryRepository $categoryRepository,
    ) {
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
    }

    // Điều hướng, hiển thị trong view, Request để bắn thông tin sang CategoryService
    public function index(Request $request) {
        // $categories = $this->categoryService->paginate($request);

        return view('admin.category.index');
    }

    public function create() {
        return view('admin.category.store');
    }
}

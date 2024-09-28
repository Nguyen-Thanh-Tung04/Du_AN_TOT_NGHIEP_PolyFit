<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\Interfaces\CategoryInterface as CategoryRepository;



class CategoryController extends Controller
{
    protected $categoryService;
    protected $CategoryRepository;

    public function __construct(
        categoryService $categoryService,
        CategoryRepository $CategoryRepository,
    ) {
        $this->categoryService = $categoryService;
        $this->CategoryRepository = $CategoryRepository;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->paginate($request);
        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
        $config['seo'] = config('apps.category');
        $template = 'admin.categories.index';
        return view('admin.dashboard.layout', compact('template', 'config', 'categories'));
    }
    public function create()
    {
        $template = 'admin.categories.store';
        $config = [
            'seo' => config('apps.category'),
            'method' => 'create',
        ];
        return view('admin.dashboard.layout', compact('template', 'config'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all(); // Lấy tất cả dữ liệu từ request
        if ($this->categoryService->create($data, $request)) {
            return redirect()->route('category.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('category.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }
    public function edit($id)
    {
        $category = $this->CategoryRepository->find($id);
        $template = 'admin.categories.update';

        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];

        $config['seo'] = config('apps.category');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'category',
            'config',
        ));
    }
    public function update($id, UpdateCategoryRequest $request)
    {
        // dd($request);
        if ($this->categoryService->update($id, $request)) {
            return redirect()->route('category.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('category.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id)
    {
        $category = $this->CategoryRepository->find($id);
        $config = [
            'seo' => config('apps.category'),
        ];
        $template = 'admin.categories.delete';
        return view('admin.dashboard.layout', compact('template', 'config', 'category'));
    }

    public function destroy($id)
    {
        if ($this->categoryService->destroy($id)) {
            return redirect()->route('category.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('category.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }
}
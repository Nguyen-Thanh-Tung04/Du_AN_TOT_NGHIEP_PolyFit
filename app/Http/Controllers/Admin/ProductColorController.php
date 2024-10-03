<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteColorRequest;
use App\Http\Requests\StoreProductColorRequest;
use App\Http\Requests\UpdateProductColorRequest;
use App\Repositories\ProductColorRepository;

use App\Services\ProductColorService;
use function Termwind\ask;
use Illuminate\Http\Request;

class ProductColorController
{
    protected $productColorService;
    protected $productColorRepository;

    public function __construct(
        ProductColorService $productColorService, 
        ProductColorRepository $productColorRepository,
    ) {
        $this->productColorService = $productColorService;
        $this->productColorRepository = $productColorRepository;
    }

    public function index(Request $request) {
        $colors = $this->productColorService->paginate($request);
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
        $config['seo'] = config('apps.color');
        $template = 'admin.product.color.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'colors',
        ));
    }

    public function create() {
   
        $template = 'admin.product.color.store';
        $config = $this->configData();
        $config['seo'] = config('apps.color');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreProductColorRequest $request) {
        // dd($request->all());
        if ($this->productColorService->create($request)) {
            return redirect()->route('product.color.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('product.color.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function edit($id) {
        $color = $this->productColorRepository->findById($id);

        $template = 'admin.product.color.update';
        $config = $this->configData();
        $config['seo'] = config('apps.color');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'color',
        ));
    }

    public function update($id, UpdateProductColorRequest $request) {
        if ($this->productColorService->update($id, $request)) {
            return redirect()->route('product.color.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('product.color.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id) {
        $color = $this->productColorRepository->findById($id);

        $config['seo'] = config('apps.color');
        $template = 'admin.product.color.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'color',
        ));
    }

    public function destroy($id, DeleteColorRequest $request) {
        if ($this->productColorService->destroy($id)) {
            return redirect()->route('product.color.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('product.color.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }

    public function configData() {
        return [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
    }
}

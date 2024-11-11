<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSizeRequest;
use App\Http\Requests\StoreProductSizeRequest;
use App\Http\Requests\UpdateProductSizeRequest;
use App\Repositories\ProductSizeRepository;

use App\Services\ProductSizeService;
use function Termwind\ask;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    protected $productSizeService;
    protected $productSizeRepository;

    public function __construct(
        ProductSizeService $productSizeService, 
        ProductSizeRepository $productSizeRepository,
    ) {
        $this->productSizeService = $productSizeService;
        $this->productSizeRepository = $productSizeRepository;
    }

    public function index(Request $request) {
        $sizes = $this->productSizeService->paginate($request);
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
        $config['seo'] = config('apps.size');
        $template = 'admin.product.size.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'sizes',
        ));
    }

    public function create() {
   
        $template = 'admin.product.size.store';
        $config = $this->configData();
        $config['seo'] = config('apps.size');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreProductSizeRequest $request) {
        if ($this->productSizeService->create($request)) {
            return redirect()->route('product.size.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('product.size.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function edit($id) {
        $size = $this->productSizeRepository->findById($id);
        // dd($size);

        $template = 'admin.product.size.update';
        $config = $this->configData();
        $config['seo'] = config('apps.size');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'size',
        ));
    }

    public function update($id, UpdateProductSizeRequest $request) {
        if ($this->productSizeService->update($id, $request)) {
            return redirect()->route('product.size.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('product.size.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id) {
        $size = $this->productSizeRepository->findById($id);

        $config['seo'] = config('apps.size');
        $template = 'admin.product.size.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'size',
        ));
    }

    public function destroy($id, DeleteSizeRequest $request) {
        if ($this->productSizeService->destroy($id)) {
            return redirect()->route('product.size.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('product.size.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
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

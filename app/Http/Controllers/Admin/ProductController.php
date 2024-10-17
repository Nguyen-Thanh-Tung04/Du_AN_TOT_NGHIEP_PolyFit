<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\DeleteProductRequest;
use App\Models\Variant;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

use function Termwind\ask;
use Illuminate\Http\Request;

class ProductController
{
    protected $productService;
    protected $productRepository;

    public function __construct(
        ProductService $productService, 
        ProductRepository $productRepository,
    ) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request) {
        $products = $this->productService->paginate($request);
        $getCategoryAttr = $this->productService->getCategoryAttr();
        $config = $this->configData();
        $config['seo'] = config('apps.product');
        $template = 'admin.product.product.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'products',
            'getCategoryAttr',
        ));
    }

    public function create() {
        $getCategoryAttr = $this->productService->getCategoryAttr();
        $getColorAttr = $this->productService->getColorAttr();
        $getSizeAttr = $this->productService->getSizeAttr();
   
        $template = 'admin.product.product.store';
        $config = $this->configData();
        $config['seo'] = config('apps.product');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'getCategoryAttr',
            'getColorAttr',
            'getSizeAttr',
        ));
    }

    public function store(StoreProductRequest $request) {
        if ($this->productService->create($request)) {
            return redirect()->route('product.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('product.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function edit($id) {
        $product = $this->productRepository->findById($id);
        // dd($product->variants);
        
        $getCategoryAttr = $this->productService->getCategoryAttr();
        $getColorAttr = $this->productService->getColorAttr();
        $getSizeAttr = $this->productService->getSizeAttr();

        $template = 'admin.product.product.update';
        $config = $this->configData();
        $config['seo'] = config('apps.product');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'product',
            'getCategoryAttr',
            'getColorAttr',
            'getSizeAttr',
        ));
    }

    public function detail($id) {
        $product = $this->productRepository->findById($id);
        
        $getCategoryAttr = $this->productService->getCategoryAttr();
        $getColorAttr = $this->productService->getColorAttr();
        $getSizeAttr = $this->productService->getSizeAttr();

        $template = 'admin.product.product.detail';
        $config = $this->configData();
        $config['seo'] = config('apps.product');
        $config['method'] = 'detail';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'product',
            'getCategoryAttr',
            'getColorAttr',
            'getSizeAttr',
        ));
    }

    public function update($id, UpdateProductRequest $request) {
        if ($this->productService->update($id, $request)) {
            return redirect()->route('product.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('product.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id) {
        $product = $this->productRepository->findById($id);
        $getCategoryAttr = $this->productService->getCategoryAttr();
        $getColorAttr = $this->productService->getColorAttr();
        $getSizeAttr = $this->productService->getSizeAttr();

        $config['seo'] = config('apps.product');
        $template = 'admin.product.product.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'product',
            'getCategoryAttr',
            'getColorAttr',
            'getSizeAttr',
        ));
    }

    public function destroy($id, DeleteProductRequest $request) {
        if ($this->productService->destroy($id)) {
            return redirect()->route('product.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('product.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }

    public function destroyVariantDetail(Request $request) {
        if ($this->productService->destroyVariant($request)) {
            return redirect()->route('product.delete', $request->id)->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('product.delete', $request->id)->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }

    public function configData() {
        return [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'admin/plugins/ckfinder_2/ckfinder.js',
                'admin/library/finder.js',
                'admin/plugins/ckeditor/ckeditor.js',
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
    }
}

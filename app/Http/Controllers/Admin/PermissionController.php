<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Requests\DeletePermissionRequest;
use App\Repositories\PermissionRepository;
use App\Services\PermissionService;

use function Termwind\ask;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $permissionRepository;

    public function __construct(
        PermissionService $permissionService, 
        PermissionRepository $permissionRepository,
    ) {
        $this->permissionService = $permissionService;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request) {
        $permissions = $this->permissionService->paginate($request);
        $config = $this->configData();
        $config['seo'] = config('apps.permission');
        $template = 'admin.permission.permission.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'permissions',
        ));
    }

    public function create() {
        $template = 'admin.permission.permission.store';
        $config = $this->configData();
        $config['seo'] = config('apps.permission');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StorePermissionRequest $request) {
        if ($this->permissionService->create($request)) {
            return redirect()->route('permission.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('permission.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function edit($id) {
        $permission = $this->permissionRepository->findById($id);

        $template = 'admin.permission.permission.update';
        $config = $this->configData();
        $config['seo'] = config('apps.permission');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'permission',
        ));
    }

    public function detail($id) {
        $permission = $this->permissionRepository->findById($id);
        
        $getCategoryAttr = $this->permissionService->getCategoryAttr();
        $getColorAttr = $this->permissionService->getColorAttr();
        $getSizeAttr = $this->permissionService->getSizeAttr();

        $template = 'admin.permission.permission.detail';
        $config = $this->configData();
        $config['seo'] = config('apps.permission');
        $config['method'] = 'detail';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'permission',
            'getCategoryAttr',
            'getColorAttr',
            'getSizeAttr',
        ));
    }

    public function update($id, UpdatePermissionRequest $request) {
        if ($this->permissionService->update($id, $request)) {
            return redirect()->route('permission.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('permission.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id) {
        $permission = $this->permissionRepository->findById($id);

        $config['seo'] = config('apps.permission');
        $template = 'admin.permission.permission.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'permission',
        ));
    }

    public function destroy($id, Request $request) {
        if ($this->permissionService->destroy($id)) {
            return redirect()->route('permission.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('permission.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }

    public function destroyVariantDetail(Request $request) {
        if ($this->permissionService->destroyVariant($request)) {
            return redirect()->route('permission.delete', $request->id)->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('permission.delete', $request->id)->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
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

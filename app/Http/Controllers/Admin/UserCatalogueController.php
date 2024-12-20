<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserCatalogueService;
use App\Repositories\UserCatalogueRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    protected $permissionRepository;

    public function __construct(
        UserCatalogueService $userCatalogueService,
        UserCatalogueRepository $userCatalogueRepository,
        PermissionRepository $permissionRepository,
    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request) {
        $userCatalogues = $this->userCatalogueService->paginate($request);
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
        $config['seo'] = config('apps.userCatalogue');
        $template = 'admin.user.catalogue.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogues',
        ));
    }

    public function create() {
        $template = 'admin.user.catalogue.store';
        $config['seo'] = config('apps.userCatalogue');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreUserCatalogueRequest $request) {
        if ($this->userCatalogueService->create($request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function edit($id) {
        $userCatalogue = $this->userCatalogueRepository->findById($id);

        $template = 'admin.user.catalogue.update';
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'admin/library/location.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
        $config['seo'] = config('apps.userCatalogue');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'userCatalogue',
            'config',
        ));
    }

    public function update($id, StoreUserCatalogueRequest $request) {
        if ($this->userCatalogueService->update($id, $request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id) {
        $userCatalogue = $this->userCatalogueRepository->findById($id);
        $config['seo'] = config('apps.userCatalogue');
        $template = 'admin.user.catalogue.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogue',
        ));
    }

    public function destroy($id) {
        if ($this->userCatalogueService->destroy($id)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }

    public function permission() {
        $userCatalogues = $this->userCatalogueRepository->all(['permissions']);
        $permissions = $this->permissionRepository->all();
        $config['seo'] = config('apps.userCatalogue');
        $config['method'] = 'permission';
        $template = 'admin.user.catalogue.permission';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'userCatalogues',
            'permissions',
        ));
    }

    public function updatePermission(Request $request) {
        if ($this->userCatalogueService->setPermission($request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Cập nhật quyền thành công.');
        }
        return redirect()->route('user.catalogue.updatePermission')->with('error', 'Có lỗi xảy ra. Hãy thử lại.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;
    protected $userCatalogueRepository;

    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,
        UserCatalogueRepository $userCatalogueRepository,
    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
        $this->userCatalogueRepository = $userCatalogueRepository;
    }

    public function index(Request $request) {
        $users = $this->userService->paginate($request);
        $getUserCatalogue = $this->userService->getUserCatalogue();
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
        $config['seo'] = config('apps.user');
        $template = 'admin.user.user.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'users',
            'getUserCatalogue',
        ));
    }

    public function create() {
        $provinces = $this->provinceRepository->all();
        $userCatalogue = $this->userCatalogueRepository->all();
        $template = 'admin.user.user.store';
        $config = $this->configData();
        $config['seo'] = config('apps.user');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
            'userCatalogue',
        ));
    }

    public function store(StoreUserRequest $request) {
        if ($this->userService->create($request)) {
            return redirect()->route('user.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('user.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function edit($id) {
        $user = $this->userRepository->findById($id);
        $userCatalogue = $this->userCatalogueRepository->all();
    //    dd($userCatalogue);die();
        $provinces = $this->provinceRepository->all();

        $template = 'admin.user.user.update';
        $config = $this->configData();
        $config['seo'] = config('apps.user');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'user',
            'userCatalogue',
            'provinces',
            'config',
        ));
    }

    public function profile($id) {
        $user = $this->userRepository->findById($id);
        $userCatalogue = $this->userCatalogueRepository->all();
        $provinces = $this->provinceRepository->all();

        $template = 'admin.user.user.profile';
        $config = $this->configData();
        $config['seo'] = config('apps.user');
        $config['method'] = 'profile';
        return view('admin.dashboard.layout', compact(
            'template',
            'user',
            'userCatalogue',
            'provinces',
            'config',
        ));
    }
    public function updateProfile($id, UpdateUserRequest $request) {
        if ($this->userService->update($id, $request)) {
            return redirect()->back()->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->back()->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function update($id, UpdateUserRequest $request) {
        if ($this->userService->update($id, $request)) {
            return redirect()->route('user.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('user.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id) {
        $user = $this->userRepository->findById($id);
        $config['seo'] = config('apps.user');
        $template = 'admin.user.user.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'user',
        ));
    }

    public function destroy($id) {
        if ($this->userService->destroy($id)) {
            return redirect()->route('user.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('user.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }

    public function configData() {
        return [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'admin/library/location.js',
                'admin/plugins/ckfinder_2/ckfinder.js',
                'admin/library/finder.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ]
        ];
    }
}

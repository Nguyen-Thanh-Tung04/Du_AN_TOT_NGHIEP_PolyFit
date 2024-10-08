<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\CheckoutService;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class CheckoutController
{
    protected $userService;
    protected $checkoutService;
    protected $provinceRepository;
    protected $userRepository;

    public function __construct(
        UserService $userService,
        CheckoutService $checkoutService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,
    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
        $this->checkoutService = $checkoutService;
    }

    public function checkout(Request $request) {
        $userId = Auth::id();
        $user = $this->userRepository->findById($userId);
        $provinces = $this->provinceRepository->all();

        return view('client.page.checkout', compact(
            'user',
            'provinces',
        ));
    }

    public function create() {
        $provinces = $this->provinceRepository->all();

        $template = 'admin.user.user.store';
        $config = $this->configData();
        $config['seo'] = config('apps.user');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
        ));
    }

    public function store(StoreUserRequest $request) {
        if ($this->userService->create($request)) {
            return redirect()->route('user.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('user.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function shippingAddress($id) {
        $user = $this->userRepository->findById($id);
        $provinces = $this->provinceRepository->all();

        $config = $this->configData();
        return view('admin.dashboard.layout', compact(
            'user',
            'userCatalogue',
            'provinces',
            'config',
        ));
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

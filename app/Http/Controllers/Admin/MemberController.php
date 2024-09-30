<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\MemberRepositoryInterface as MemberRepository;

class MemberController
{
    protected $memberService;
    protected $provinceRepository;
    protected $memberRepository;

    public function __construct(
        MemberService $memberService,
        ProvinceRepository $provinceRepository,
        MemberRepository $memberRepository,
    ) {
        $this->memberService = $memberService;
        $this->provinceRepository = $provinceRepository;
        $this->memberRepository = $memberRepository;
    }

    public function index(Request $request) {
        $members = $this->memberService->paginate($request);
//        dd($members);die();
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
        $config['seo'] = config('apps.member');
//        $template = 'admin.user.member.index';
        $template = 'admin.user.member.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'members',
        ));
    }

    public function create() {
        $provinces = $this->provinceRepository->all();

        $template = 'admin.user.member.store';
        $config = $this->configData();
        $config['seo'] = config('apps.member');
        $config['method'] = 'create';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
        ));
    }

    public function store(StoreUserRequest $request) {
        if ($this->memberService->create($request)) {
            return redirect()->route('member.index')->with('success', 'Thêm mới bản ghi thành công.');
        }
        return redirect()->route('member.index')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    public function edit($id) {
        $user = $this->memberRepository->findById($id);
        $provinces = $this->provinceRepository->all();

        $template = 'admin.user.member.update';
        $config = $this->configData();
        $config['seo'] = config('apps.member');
        $config['method'] = 'edit';
        return view('admin.dashboard.layout', compact(
            'template',
            'user',
            'provinces',
            'config',
        ));
    }

    public function update($id, UpdateMemberRequest $request) {
//        dd($request);die();
        if ($this->memberService->update($id, $request)) {
            return redirect()->route('member.index')->with('success', 'Cập nhật bản ghi thành công.');
        }
        return redirect()->route('member.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    public function delete($id) {
        $user = $this->memberRepository->findById($id);
        $config['seo'] = config('apps.member');
        $template = 'admin.user.member.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'user',
        ));
    }

    public function destroy($id) {
        if ($this->memberService->destroy($id)) {
            return redirect()->route('member.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('member.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
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

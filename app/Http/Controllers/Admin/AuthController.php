<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_catalogue_id != 3) {
                return redirect()->route('dashboard.index');
            }
        }
        return view('admin.auth.login')->with('error', 'Tài khoản không được truy cập vào chức năng này!');
    }
    public function login()
    {
        return view('client.page.login');
    }
    public function loginclient(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->publish !== 1) {
                return redirect()
                    ->route('auth.client-login')
                    ->with('error', 'Tài khoản của bạn đang bị khóa hoặc chưa được kích hoạt.');
            }

            return redirect()->route('home')->with('success', 'Đăng nhập thành công.');
        }

        return redirect()
            ->route('auth.client-login')
            ->with('error', 'Email hoặc mật khẩu không chính xác.')
            ->withInput();
    }
    public function logined(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->user_catalogue_id == 3) {
                Auth::logout();
                return redirect()->route('auth.login')->with('error', 'Tài khoản không hợp lệ.');
            }
            return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công.');
        }
        return redirect()->route('auth.login')->with('error', 'Email hoặc mật khẩu không chính xác.')->withInput();;
    }

    public function showFormRegister()
    {
        return view('client.page.register');
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $data['user_catalogue_id'] = 3;
        $user = User::create($data);
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công và bạn đã được đăng nhập!');
    }
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra trạng thái người dùng trước khi đăng xuất
        if ($user && $user->user_catalogue_id  != 3) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            // Chuyển hướng tới trang đăng nhập của admin
            return redirect()->route('auth.login');
        } else if ($user && $user->user_catalogue_id === 3) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            // Chuyển hướng tới trang đăng nhập của client
            return redirect()->route('auth.client-login');
        }
        return redirect()->route('auth.client-login');
    }

}

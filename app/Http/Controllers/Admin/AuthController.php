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
        return view('admin.auth.login');
    }
    public function login()
    {
        return view('client.page.login');
    }
    public function loginclient(AuthRequest $request)
    {
        // Xác thực thông tin đăng nhập
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // Nếu đăng nhập thành công
        if (Auth::attempt($credentials)) {
            // Lấy thông tin người dùng đã đăng nhập
            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản: 1 là mơ, 2 là khóa
            if ($user->publish !== 1) {
                return redirect()->route('auth.client-login')->with('error', 'Tài khoản của bạn đang bị khóa hoặc chưa được kích hoạt.');
            }

            // Nếu tài khoản hợp lệ, chuyển hướng đến trang chủ
            return redirect()->route('home')->with('success', 'Đăng nhập thành công.');
        }

        // Nếu thông tin đăng nhập không đúng
        return redirect()->route('auth.client-login')->with('error', 'Email hoặc mật khẩu không chính xác.');
    }

    public function logined(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // Nếu đăng nhập thành công
        if (Auth::attempt($credentials)) {
            // Lấy thông tin người dùng đã đăng nhập
            $user = Auth::user();
            //            dd($user->user_catalogue_id );
            // Check tài khoản xem có phải tài khoản admin không
            if ($user->user_catalogue_id == null) {
                Auth::logout();
                return redirect()->route('auth.login')->with('error', 'Tài khoản không hợp lệ.');
            }

            // Nếu tài khoản hợp lệ, chuyển hướng đến trang chủ
            return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công.');
        }
        return redirect()->route('auth.login')->with('error', 'Email hoặc mật khẩu không chính xác.');
    }

    public function showFormRegister()
    {
        return view('client.page.register');
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return redirect()->route('auth.client-login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra trạng thái người dùng trước khi đăng xuất
        if ($user && $user->user_catalogue_id  > 0) {
            // Nếu người dùng là admin hoặc có điều kiện bạn mong muốn, thực hiện đăng xuất
            Auth::logout();

            // Xóa phiên tùy chỉnh nếu có
            session()->forget('selected_items');

            // Làm sạch phiên người dùng để bảo mật
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Chuyển hướng tới trang đăng nhập của admin
            return redirect()->route('auth.login');
        } else if ($user && $user->publish == null) {
            // Nếu người dùng không phải là admin, hoặc điều kiện khác
            Auth::logout();

            // Xóa phiên tùy chỉnh nếu có
            session()->forget('selected_items');

            // Làm sạch phiên người dùng để bảo mật
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Chuyển hướng tới trang đăng nhập của client
            return redirect()->route('auth.client-login');
        }

        // Trường hợp người dùng không hợp lệ (chưa đăng nhập)
        return redirect()->route('auth.client-login');
    }

}
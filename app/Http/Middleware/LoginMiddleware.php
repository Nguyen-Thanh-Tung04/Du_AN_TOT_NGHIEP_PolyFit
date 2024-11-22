<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            $user = Auth::user();

            // Nếu là admin (user_catalogue_id != 3), cho phép tiếp tục
            if ($user->user_catalogue_id != 3) {
                return $next($request);
            }

            // Nếu không phải admin, chuyển hướng đến trang đăng nhập
            return redirect()->route('auth.login')
                             ->with('error', 'Tài khoản không được phép truy cập vào chức năng này.');
        }

        // Nếu chưa đăng nhập
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập để sử dụng chức năng này.'
            ], 401);
        }

        // Chuyển hướng đến trang đăng nhập
        return redirect()->route('auth.login')
                         ->with('error', 'Bạn phải đăng nhập để sử dụng chức năng này.');
    }
}

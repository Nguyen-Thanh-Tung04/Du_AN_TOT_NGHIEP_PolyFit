<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::id() == null) {
            if ($request->ajax() || $request->wantsJson()) {

                return response()->json([
                    'status' => false,
                    'message' => 'Bạn phải đăng nhập để sử dụng chức năng này'
                ], 401);
            }
            return redirect()->route('auth.login')->with('error', 'Bạn phải đăng nhập để sử dụng chức năng này');
        }
        return $next($request);
    }
}

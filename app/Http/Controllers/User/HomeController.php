<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Variants;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function welcome()
    {
        // Sử dụng join để kết nối bảng product và variants
        $products = Product::select(
            'products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price')
        )
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->groupBy('products.id')
            ->get();

        // câu lệnh hiển thị sản phẩm giảm giá
        $discounted = Product::select(
            'products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MIN(variants.listed_price) as listed_price')
        )
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->whereColumn('variants.listed_price', '>', 'variants.sale_price')
            ->groupBy('products.id')
            ->get();


        // Tạo một mảng kết hợp chứa dữ liệu cần truyền tới view
        $data = [
            'products' => $products,
            'discounted' => $discounted,
        ];

        $category = Category::all();

        // Tính điểm trung bình cho từng sản phẩm và gán vào thuộc tính mới
        foreach ($products as $product) {
            $product->averageScore = $product->averageScore(); // Gọi hàm averageScore() từ Model Product
        }

        // Debug để kiểm tra dữ liệu
        // dd($data);

        return view('welcome', $data, compact('category'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search'); // Lấy giá trị tìm kiếm từ input

        // Truy vấn tìm kiếm sản phẩm
        $products = Product::with('variants') // Eager load variants để giảm số lượng truy vấn
            ->where('name', 'like', "%{$search}%") // Tìm kiếm theo tên sản phẩm
            ->orWhere('code', 'like', "%{$search}%") // Tìm kiếm theo mã sản phẩm
            ->get();

        // Tạo một mảng dữ liệu để truyền tới view
        $data = [
            'products' => $products,
            'search' => $search, // Truyền biến tìm kiếm tới view để hiển thị
        ];

        $category = Category::all();

        return view('welcome', $data, compact('products', 'search', 'category')); // Chuyển hướng tới view kết quả tìm kiếm
    }


    // gửi email quên mật khẩu

    public function forgetPass()
    {
        return view('client.passwords.forgetPass');
    }

    public function postForgetPass(Request $req)
    {
        // Validate email
        $req->validate([
            'email' => 'required|exists:users,email'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email hợp lệ',
            'email.exists' => 'Email này không tồn tại trong hệ thống'
        ]);

        // Gửi email với liên kết chứa email và thời gian hết hạn
        $expirationTime = now()->addHours(1)->timestamp; // Thời gian hết hạn là 1 giờ
        $resetLink = route('getPass', ['email' => $req->email, 'expires' => $expirationTime]);

        Mail::to($req->email)->send(new ResetPasswordMail($req->email, $resetLink));

        return redirect()->route('auth.client-login')->with('success', 'Vui lòng kiểm tra email để thực hiện thay đổi mật khẩu');
    }

    public function getPass(Request $req)
    {
        $email = $req->query('email');
        $expires = $req->query('expires');

        // Kiểm tra nếu liên kết đã hết hạn
        if (now()->timestamp > $expires) {
            return abort(404, 'Liên kết đã hết hạn');
        }

        // Kiểm tra email có hợp lệ không
        $customer = User::where('email', $email)->first();
        if (!$customer) {
            return abort(404, 'Email không hợp lệ');
        }

        return view('client.passwords.getPass', compact('customer', 'email', 'expires'));
    }

    public function postGetPass(Request $req)
    {
        $req->validate([
            'password' => 'required|min:8', // Đảm bảo mật khẩu dài tối thiểu 8 ký tự
            'password_confirmation' => 'required|same:password',
        ]);

        // Mã hóa mật khẩu
        $password_h = bcrypt($req->password);
        $customer = User::where('email', $req->email)->first();
        $customer->update(['password' => $password_h]);

        return redirect()->route('auth.client-login')->with('success', 'Đặt lại mật khẩu thành công');
    }

}
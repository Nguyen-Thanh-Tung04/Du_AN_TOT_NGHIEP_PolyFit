<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Variants;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class HomeController extends Controller
{
    public function welcome(){
        // Sử dụng join để kết nối bảng product và variants
        $products = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->groupBy('products.id')
            ->get();

        // câu lệnh hiển thị sản phẩm giảm giá
        $discounted = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
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

        // Debug để kiểm tra dữ liệu
        // dd($data);

        return view('welcome', $data, compact('category') );
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
        return view('client.ResetPass.forgetPass');
    }

    public function postForgetPass (Request $req)
    {
        $req->validate([
        'email' => 'required exists:customer'
        ],[
        'email.required' => 'Vui lòng nhập địa chỉ email hợp lệ',
        'email.exists' => 'Email này không tông tại trong hệ thống'
        ]);

        $token = strtoupper (Str::random(10));
        $customer = Customer::where('email', $req->email)->first();
        $customer->update(['token' => $token]);
        Mail::send('emails.check_email_forget', compact('customer'),function($email) use($customer){
            $email->subject ('MyShoping - Lấy lại mật khẩu tài khoản');
            $email->to($customer->email, $customer->name);
            return redirect()->back('home.login')->with('yes', 'Vui lòng check email để thự hiện thay đổi mật khẩu');
        });

    }
}

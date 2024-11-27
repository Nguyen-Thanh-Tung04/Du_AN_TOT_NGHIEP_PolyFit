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
use App\Models\Color;
use App\Models\Size;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function welcome()
    {

        $users = User::select('users.id', 'users.name', 'users.image')
            ->leftJoin('message_private as m', function ($join) {
                $join->on('users.id', '=', 'm.user_reciever')
                    ->where('m.created_at', '>=', now()->subMinutes(5));
            })
            ->where('users.user_catalogue_id', 2)
            // ->where('users.id', '<>', Auth::user()->id)
            ->groupBy('users.id', 'users.name')
            ->havingRaw('COUNT(DISTINCT m.user_send) <= 5')
            ->limit(3)  // Lấy 3 nhân viên
            ->get();

        // Hiển thị kết quả
        // dd($availableStaff);
        $user = Auth::user();


        // dd($users);
        // Top 8 sản phẩm mới đang có status active và tổng số lượng các variant > 0
        $newProducts = Product::select(
            'products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'),
            DB::raw('SUM(variants.quantity) as total_quantity')
        )
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->where('products.status', 1)
            ->groupBy('products.id')
            ->having('total_quantity', '>', 0) // Chỉ lấy sản phẩm có tổng quantity > 0
            ->orderBy('products.created_at', 'desc')
            ->limit(8)
            ->get();

        // Top 8 sản phẩm bán chạy dựa vào bảng order_items
        $bestSellingProducts = Product::select(
            'products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'),
            DB::raw('SUM(order_items.quantity) as total_sold')
        )
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->join('order_items', 'variants.id', '=', 'order_items.variant_id')
            ->where('products.status', 1)
            ->groupBy('products.id')
            ->having('total_sold', '>', 0) // Chỉ lấy sản phẩm có tổng quantity sold > 0
            ->orderBy('total_sold', 'desc')
            ->limit(8)
            ->get();


        $productsFlashSale = $this->getActiveFlashSaleProducts();

        // Tính điểm trung bình cho từng sản phẩm và gán vào thuộc tính mới
        foreach ($newProducts as $product) {
            $product->averageScore = $product->averageScore(); // Gọi hàm averageScore() từ Model Product
        }

        // Tính điểm trung bình cho từng sản phẩm và gán vào thuộc tính mới
        foreach ($bestSellingProducts as $product) {
            $product->averageScore = $product->averageScore(); // Gọi hàm averageScore() từ Model Product
        }

        $data = [
            'newProducts' => $newProducts,
            'bestSellingProducts' => $bestSellingProducts,
            'users' => $users,
            'user' => $user

        ];

        $categories = Category::where('is_active', 1)
        ->withCount('products') // Đếm số lượng sản phẩm
        ->get();
        // dd($categories);


        return view('client.welcome', $data, compact('categories', 'productsFlashSale'));
    }

    public function getActiveFlashSaleProducts()
    {
        $currentDateTime = Carbon::now();

        $products = Product::where('status', 1)
            ->whereHas('flashSaleProducts.flashSale', function ($query) use ($currentDateTime) {
                $query->where('status', 1)
                    ->where('date', $currentDateTime->toDateString())
                    ->where(function ($query) use ($currentDateTime) {
                        $currentHour = now()->hour;
                        $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour]) // Giờ bắt đầu <= giờ hiện tại
                            ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]); // Giờ kết thúc > giờ hiện tại
                    });
            })
            ->with(['flashSaleProducts' => function ($query) {
                $query->whereHas('flashSale', function ($query) {
                    $query->where('status', 1)
                        ->where('quantity', '>', 0)
                        ->where('date', now()->toDateString())
                        ->where(function ($query) {
                            $currentHour = now()->hour;
                            $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour]) // Giờ bắt đầu <= giờ hiện tại
                                ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]); // Giờ kết thúc > giờ hiện tại
                        });
                })
                    ->orderBy('flash_price', 'asc');
            }])
            ->get();

        $products->each(function ($product) {
            $product->averageScore = $product->averageScore();
            $flashSaleProduct = $product->flashSaleProducts->first();
            if ($flashSaleProduct) {
                $product->flash_sale_price = $flashSaleProduct->flash_price;
                $product->listed_price = $flashSaleProduct->listed_price;
                $product->discount_percentage = $flashSaleProduct->discount_percentage;
            } else {
                $product->flash_sale_price = null;
                $product->listed_price = $product->variants->min('listed_price');
                $product->discount_percentage = null;
            }
        });

        return $products;
    }


    public function search(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm
        $categories = Category::where('is_active', 1)->get();

        // Khởi tạo truy vấn với các điều kiện mặc định
        $query = Product::with('variants', 'reviews')->where('products.status', 1);

        // Nếu có từ khóa tìm kiếm thì tìm theo tên hoặc mã sản phẩm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Tìm kiếm theo danh mục
        if ($request->has('category') && $request->category) {
            $categoryIds = explode(',', $request->category);
            $query->whereIn('category_id', $categoryIds);
        }

        // Tìm kiếm theo khoảng giá
        if ($request->has('min_price') && $request->min_price) {
            $minPrice = $request->min_price;
            $query->whereHas('variants', function ($q) use ($minPrice) {
                $q->where('sale_price', '>=', $minPrice);
            });
        }

        if ($request->has('max_price') && $request->max_price) {
            $maxPrice = $request->max_price;
            $query->whereHas('variants', function ($q) use ($maxPrice) {
                $q->where('sale_price', '<=', $maxPrice);
            });
        }

        // Tìm kiếm theo màu sắc
        if ($request->has('color') && $request->color) {
            $colorIdsRQ = explode(',', $request->color);
            $query->whereHas('variants', function ($q) use ($colorIdsRQ) {
                $q->whereIn('color_id', $colorIdsRQ);
            });
        }

        // Tìm kiếm theo kích cỡ
        if ($request->has('size') && $request->size) {
            $sizeIdsRQ = explode(',', $request->size);
            $query->whereHas('variants', function ($q) use ($sizeIdsRQ) {
                $q->whereIn('size_id', $sizeIdsRQ);
            });
        }

        // Sắp xếp kết quả tìm kiếm
        if ($request->has('sort')) {
            $sort = $request->sort;
            if ($sort == 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($sort == 'name_desc') {
                $query->orderBy('name', 'desc');
            } elseif ($sort == 'price_asc') {
                $query->join('variants', 'products.id', '=', 'variants.product_id')
                    ->where('products.status', 1)
                    ->groupBy('products.id', 'products.name')
                    ->select('products.*', DB::raw('MIN(variants.sale_price) as min_sale_price'))
                    ->orderBy('min_sale_price', 'asc');
            } elseif ($sort == 'price_desc') {
                $query->join('variants', 'products.id', '=', 'variants.product_id')
                    ->where('products.status', 1)
                    ->groupBy('products.id', 'products.name')
                    ->select('products.*', DB::raw('MAX(variants.sale_price) as max_sale_price'))
                    ->orderBy('max_sale_price', 'desc');
            }
        } else {
            $query->orderBy('products.name', 'asc');
        }

        // Phân trang kết quả tìm kiếm
        $products = $query->paginate(10);

        // Tính giá bán và giá niêm yết tối thiểu cho từng sản phẩm
        foreach ($products as $product) {
            $variant = $product->variants()
                ->select('sale_price', 'listed_price')
                ->get()
                ->sortBy(function ($variant) {
                    return $variant->sale_price !== null ? $variant->sale_price : $variant->listed_price;
                })
                ->first();

            $product->setAttribute('min_sale_price', $variant->sale_price ?? null);
            $product->setAttribute('min_listed_price', $variant->listed_price ?? null);
        }

        // Tính điểm trung bình cho từng sản phẩm
        foreach ($products as $product) {
            $product->averageScore = $product->averageScore(); // Gọi hàm averageScore() từ Model Product
        }

        // Lấy danh sách màu sắc và kích cỡ
        $colorIds = Variant::distinct()->pluck('color_id');
        $sizeIds = Variant::distinct()->pluck('size_id');
        $colors = Color::whereIn('id', $colorIds)->get();
        $sizes = Size::whereIn('id', $sizeIds)->get();

        // Thông báo tìm kiếm
        $message = '';
        if ($products->isEmpty()) {
            $message = 'Không có sản phẩm nào phù hợp với từ khóa "' . $search . '".';
        } else {
            $message = 'Tìm thấy ' . $products->total() . ' sản phẩm phù hợp với từ khóa "' . $search . '".';
        }

        // Trả kết quả tìm kiếm ra view
        return view('client.page.shop', compact('products', 'search', 'categories', 'colors', 'sizes', 'message'));
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

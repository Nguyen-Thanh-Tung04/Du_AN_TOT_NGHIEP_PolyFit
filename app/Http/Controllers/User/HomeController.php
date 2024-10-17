<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Variants;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}

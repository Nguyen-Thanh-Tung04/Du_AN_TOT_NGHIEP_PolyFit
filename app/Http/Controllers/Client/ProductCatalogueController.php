<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;

class ProductCatalogueController
{
    public function __construct()
    {

    }
    public function index(){
        // Sử dụng join để kết nối bảng product và variants
        $products = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->groupBy('products.id')
            ->paginate(8); // Sử dụng paginate để chia trang, với 8 sản phẩm mỗi trang


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

        $categories = Category::all();
        $variants = Variant::all();
//        dd(@$variants);
        // Debug để kiểm tra dữ liệu
        // dd($data);

        return view('client.page.shop', $data, compact('categories', 'variants') );
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCatalogueController
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        // Khởi tạo truy vấn sản phẩm với thông tin biến thể
        $query = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->groupBy('products.id');

        // Kiểm tra tham số sắp xếp và áp dụng sắp xếp vào truy vấn
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'name_asc':
                    $query->orderBy('products.name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('products.name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('min_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('min_price', 'desc');
                    break;
            }
        }

        // Lấy dữ liệu sản phẩm sau khi đã sắp xếp
        $products = $query->get();

        // Lấy danh sách các sản phẩm có giảm giá
        $discounted = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->whereColumn('variants.listed_price', '>', 'variants.sale_price')
            ->groupBy('products.id')
            ->get();

        // Lấy danh sách các danh mục và biến thể
        $categories = Category::all();
        $variants = Variant::all();

        // Tạo mảng dữ liệu để truyền vào view
        $data = [
            'products' => $products,
            'discounted' => $discounted,
            'categories' => $categories,
            'variants' => $variants,
        ];

        // Trả về view với dữ liệu đã truyền
        return view('client.page.shop', $data);
    }
    public function show(Request $request, $id)
    {
        // Lấy danh mục theo ID
        $category = Category::findOrFail($id);

        // Truy vấn sản phẩm thuộc danh mục với việc tính toán giá
        $query = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->where('products.category_id', $category->id) // Thêm điều kiện để chỉ lấy sản phẩm thuộc danh mục
            ->groupBy('products.id');

        // Kiểm tra tham số sắp xếp và áp dụng sắp xếp vào truy vấn
        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'name_asc':
                    $query->orderBy('products.name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('products.name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('min_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('min_price', 'desc');
                    break;
            }
        }

        // Lấy dữ liệu sản phẩm sau khi đã sắp xếp
        $products = $query->get();

        // Lấy danh sách các sản phẩm có giảm giá
        $discounted = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->whereColumn('variants.listed_price', '>', 'variants.sale_price')
            ->groupBy('products.id')
            ->get();

        // Lấy danh sách các danh mục và biến thể
        $categories = Category::all();
        $variants = Variant::all();

        // Tạo mảng dữ liệu để truyền vào view
        $data = [
            'products' => $products,
            'discounted' => $discounted,
            'categories' => $categories,
            'variants' => $variants,
        ];

        // Trả về view với dữ liệu đã truyền
        return view('client.page.shop', $data);
    }


}

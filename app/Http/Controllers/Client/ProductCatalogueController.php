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
    public function show(Request $request)
    {
        $sizes = $request->get('sizes', []);
        $categories = $request->get('categories', []);
        $colors = $request->get('colors', []);
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', 250);

        $query = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->groupBy('products.id');

        // Lọc theo giá
        $query->whereBetween('variants.sale_price', [$minPrice, $maxPrice]);

        // Sắp xếp theo yêu cầu
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

        // Lọc theo size
        if (!empty($sizes)) {
            $query->whereHas('variants', function ($query) use ($sizes) {
                $query->whereIn('size_id', $sizes);
            });
        }

        // Lọc theo màu sắc
        if (!empty($colors)) {
            $query->whereHas('variants', function ($query) use ($colors) {
                $query->whereIn('color_id', $colors);
            });
        }

        // Lọc theo danh mục
        if (!empty($categories)) {
            $query->whereIn('products.category_id', $categories);
        }

        // Lấy danh sách sản phẩm sau khi lọc
        $products = $query->get();

        // Lấy danh sách tất cả các biến thể để hiển thị lại các size, màu sắc trong sidebar
        $variants = Variant::all();
        $categories = Category::all(); // Để hiển thị lại các danh mục

        return view('client.page.shop', compact('products', 'variants', 'categories'));
    }
    public function filter(Request $request)
    {
        $sizes = $request->get('sizes', []);
        $categories = $request->get('categories', []);
        $colors = $request->get('colors', []);

        $query = Product::select('products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price'))
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->groupBy('products.id');

        // Sắp xếp theo yêu cầu
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

        // Lọc theo size
        if (!empty($sizes)) {
            $query->whereHas('variants', function ($query) use ($sizes) {
                $query->whereIn('size_id', $sizes);
            });
        }

        // Lọc theo màu sắc
        if (!empty($colors)) {
            $query->whereHas('variants', function ($query) use ($colors) {
                $query->whereIn('color_id', $colors);
            });
        }

        // Lọc theo danh mục
        if (!empty($categories)) {
            $query->whereIn('products.category_id', $categories);
        }

        // Lấy danh sách sản phẩm sau khi lọc
        $products = $query->get();

        // Lấy danh sách tất cả các biến thể để hiển thị lại các size, màu sắc trong sidebar
        $variants = Variant::all();
        $categories = Category::all(); // Để hiển thị lại các danh mục

        return view('client.page.shop', compact('products', 'variants', 'categories'));
    }



}

<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCatalogueController
{
    public function __construct() {}

    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('variants', 'reviews')->where('products.status', 1);

        $colorIds = [];
        foreach ($query->get() as $product) {
            $variantColorIds = $product->variants->pluck('color_id')->unique()->toArray();
            $colorIds = array_unique(array_merge($colorIds, $variantColorIds));
        }

        $sizeIds = [];
        foreach ($query->get() as $product) {
            $variantSizeIds = $product->variants->pluck('size_id')->unique()->toArray();
            $sizeIds = array_unique(array_merge($sizeIds, $variantSizeIds));
        }

        $colors = Color::whereIn('id', $colorIds)->get();
        $sizes = Size::whereIn('id', $sizeIds)->get();

        if ($request->has('category')) {
            $categoryIds = explode(',', $request->category);
            $query->whereIn('category_id', $categoryIds);
        }

        if ($request->has('color')) {
            $colorIdsRQ = explode(',', $request->color);
            $query->whereHas('variants', function ($q) use ($colorIdsRQ) {
                $q->whereIn('color_id', $colorIdsRQ);
            });
        }

        if ($request->has('size')) {
            $sizeIdsRQ = explode(',', $request->size);
            $query->whereHas('variants', function ($q) use ($sizeIdsRQ) {
                $q->whereIn('size_id', $sizeIdsRQ);
            });
        }

        if ($request->has('min_price')) {
            $minPrice = $request->min_price;
            $query->whereHas('variants', function ($q) use ($minPrice) {
                $q->where('sale_price', '>=', $minPrice);
            });
        }
        if ($request->has('max_price')) {
            $maxPrice = $request->max_price;
            $query->whereHas('variants', function ($q) use ($maxPrice) {
                $q->where('sale_price', '<=', $maxPrice);
            });
        }

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
                    ->orderBy('min_sale_price', 'ASC');
            } elseif ($sort == 'price_desc') {
                $query->join('variants', 'products.id', '=', 'variants.product_id')
                    ->where('products.status', 1)
                    ->groupBy('products.id', 'products.name')
                    ->select('products.*', DB::raw('MAX(variants.sale_price) as max_sale_price'))
                    ->orderBy('max_sale_price', 'DESC');
            }
        } else {
            $query->orderBy('products.name', 'asc');
        }

        $products = $query->paginate(10);

        foreach ($products as $product) {
            $variant = $product->variants()
                ->select('sale_price', 'listed_price')
                ->get()
                ->sortBy(function ($variant) {
                    return $variant->sale_price !== null ? $variant->sale_price : $variant->listed_price;
                })
                ->first();

            if ($variant) {
                $product->setAttribute('min_sale_price', $variant->sale_price);
                $product->setAttribute('min_listed_price', $variant->listed_price);
            } else {
                $product->setAttribute('min_sale_price', null);
                $product->setAttribute('min_listed_price', null);
            }
        }

        return view('client.page.shop', compact('products', 'categories', 'colors', 'sizes'));
    }
}
<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FlashSaleProduct;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientProductController extends Controller
{


    public function __construct() {}

    public function show($id)
    {
        $product = Product::with(['category', 'variants.color', 'variants.size'])->findOrFail($id);

        // Kiểm tra xem sản phẩm có trong chương trình flash sale hay không
        $flashSaleProducts = $product->flashSaleProducts()->whereHas('flashSale', function ($query) {
            $query->where('status', 1)
                ->where('date', now()->toDateString())
                ->where(function ($query) {
                    $currentHour = now()->hour;
                    $currentMinute = now()->minute;
                    $query->whereRaw('? BETWEEN SUBSTRING_INDEX(time_slot, "-", 1) AND SUBSTRING_INDEX(time_slot, "-", 1) - 1', [$currentHour])
                        ->orWhereRaw('? = SUBSTRING_INDEX(time_slot, "-", 1) AND ? < 60', [$currentHour, $currentMinute]);
                });
        })
            ->where('status', 1)
            ->where('quantity', '>', 0)
            ->get();


        $product->is_in_flash_sale = $flashSaleProducts->isNotEmpty();
        $flashSaleEndTime = null;
        // Lấy giá variant nhỏ nhất và % giảm giá
        $minSalePrice = null;
        $discountPercentage = null;
        $minListedPrice = null;

        if ($product->is_in_flash_sale) {
            $flashSaleEndTime = now()->toDateString() . ' ' . explode('-', $flashSaleProducts->first()->flashSale->time_slot)[1] . ':00:00';
            $minFlashSaleProduct = $flashSaleProducts->sortBy('flash_price')->first();
            $minSalePrice = $minFlashSaleProduct->flash_price;
            $minListedPrice = $minFlashSaleProduct->listed_price;
            $discountPercentage = $minFlashSaleProduct->discount_percentage;
        } else {
            $minVariant = $product->variants->sortBy(function ($variant) {
                return $variant->sale_price ?? $variant->listed_price;
            })->first();

            $minListedPrice = $minVariant->listed_price;
            $minSalePrice = $minVariant->sale_price;
            $discountPercentage = $minSalePrice ? round((($minListedPrice - $minSalePrice) / $minListedPrice) * 100) : null;
        }

        // Lấy các sản phẩm tương tự (cùng danh mục) nhưng không bao gồm sản phẩm hiện tại
        $similar_products = Product::select(
            'products.*',
            DB::raw('MIN(variants.sale_price) as min_price'),
            DB::raw('MAX(variants.sale_price) as max_price'),
            DB::raw('MIN(variants.listed_price) as listed_price')
        )
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->where('products.category_id', $product->category_id) // Lọc theo danh mục của sản phẩm hiện tại
            ->where('products.id', '!=', $product->id) // Loại trừ sản phẩm hiện tại
            ->groupBy('products.id')
            ->get();

        $galleryString = str_replace("'", '"', $product->gallery);

        $galleryImages = json_decode($galleryString);

        $reviews = Review::with('replies')
            ->where('product_id', $id)
            ->where('status', '!=', 2) // Exclude reviews with status 2
            ->get();

        // Lấy điểm đánh giá trung bình
        $averageScore = $product->averageScore();

        return view(
            'client.page.productDetail',
            compact('product', 'minListedPrice', 'minSalePrice', 'galleryImages', 'averageScore', 'reviews', 'similar_products', 'discountPercentage', 'flashSaleEndTime')
        );
    }

    public function getVariantDetails(Request $request)
    {
        $variant = Variant::where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->where('size_id', $request->size_id)
            ->first();

        if ($variant) {
            // Kiểm tra xem variant có trong chương trình flash sale đang diễn ra hay không
            $flashSaleProduct = FlashSaleProduct::where('variant_id', $variant->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('status', 1)
                        ->where('date', now()->toDateString())
                        ->where(function ($query) {
                            $currentHour = now()->hour;
                            $currentMinute = now()->minute;
                            $query->whereRaw('? BETWEEN SUBSTRING_INDEX(time_slot, "-", 1) AND SUBSTRING_INDEX(time_slot, "-", 1) - 1', [$currentHour])
                                ->orWhereRaw('? = SUBSTRING_INDEX(time_slot, "-", 1) AND ? < 60', [$currentHour, $currentMinute]);
                        });
                })
                ->where('status', 1)
                ->where('quantity', '>', 0)
                ->first();

            if ($flashSaleProduct) {
                return response()->json([
                    'status' => true,
                    'data' => [
                        'listed_price' => $variant->listed_price,
                        'sale_price' => $flashSaleProduct->flash_price,
                        'discount_percentage' => $flashSaleProduct->discount_percentage,
                        'is_in_flash_sale' => true
                    ]
                ]);
            } else {
                $discountPercentage = null;
                if ($variant->sale_price) {
                    $discountPercentage = (($variant->listed_price - $variant->sale_price) / $variant->listed_price) * 100;
                }
                return response()->json([
                    'status' => true,
                    'data' => [
                        'listed_price' => $variant->listed_price,
                        'sale_price' => $variant->sale_price,
                        'discount_percentage' => $discountPercentage,
                        'is_in_flash_sale' => false
                    ]
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Variant not found'
            ]);
        }
    }
}

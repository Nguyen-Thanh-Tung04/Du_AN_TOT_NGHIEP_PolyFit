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

        $totalQuantity = $product->variants->sum('quantity');
        $product->total_quantity = $totalQuantity;

        // Kiểm tra xem sản phẩm có trong chương trình flash sale hay không
        $flashSaleProducts = $product->flashSaleProducts()->whereHas('flashSale', function ($query) {
            $query->where('status', 1)
                ->where('date', now()->toDateString())
                ->where(function ($query) {
                    $currentHour = now()->hour;
                    $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour]) // Giờ bắt đầu <= giờ hiện tại
                        ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]); // Giờ kết thúc > giờ hiện tại
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

        $reviews = Review::with('replies', 'user','order.orderItems')
            ->where('product_id', $id)
            ->where('status', '!=', 2) // Exclude reviews with status 2
            ->get(); 
        // $reviews = Review::with(['order.orderItems' => function($query) use ($id) {
        //     // Lọc orderItems theo order_id và product_id
        //     $query->where('order_id', '=', $id);  // Lọc theo order_id
        // }, 'replies', 'user'])  // Eager load các mối quan hệ còn lại
        //     ->where('product_id', $id) // Lọc theo product_id của Review
        //     ->where('status', '!=', 2)  // Loại bỏ đánh giá có trạng thái = 2
        //     ->get();
        
        
    


        // Lấy điểm đánh giá trung bình
        $averageScore = $product->averageScore();

        // Đếm số lượng đánh giá theo từng sao
        $reviewCounts = Review::where('product_id', $id)
            ->where('status', '!=', 2) // Chỉ lấy các đánh giá được duyệt
            ->selectRaw('score, COUNT(*) as count')
            ->groupBy('score')
            ->pluck('count', 'score');

        return view(
            'client.page.productDetail',
            compact('product', 'minListedPrice', 'minSalePrice', 'galleryImages', 'averageScore', 'reviews', 'similar_products', 'discountPercentage', 'flashSaleEndTime', 'reviewCounts')
        );
    }
    public function filterReviews(Request $request, $product_id)
    {
        $star = $request->get('star'); // Số sao lọc
        $query = Review::with('replies')->where('product_id', $product_id);
        // Lọc theo số sao nếu được cung cấp
        if ($star) {
            $query->where('score', $star);
        }

        // Chỉ lấy đánh giá đã được duyệt (status != 2)
        $reviews = $query->where('status', '!=', 2)->get();
        return response()->json([
            'html' => view('client.page.partials', compact('reviews'))->render()
        ]);
    }
    public function fetchReviews(Request $request, $product_id)
    {
        dd("Tung");
        // Lấy danh sách đánh giá với phân trang
        $reviews = Review::with('replies', 'user')
            ->where('product_id', $product_id)
            ->where('status', '!=', 2) // Exclude reviews with status 2
            ->paginate(5); // Số đánh giá mỗi trang

        // Render view của danh sách đánh giá và trả về HTML
        $html = view('client.page.partials', compact('reviews'))->render();

        return response()->json(['html' => $html]);
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
                            $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour]) // Giờ bắt đầu <= giờ hiện tại
                                ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]); // Giờ kết thúc > giờ hiện tại
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
                        'quantity' => $variant->quantity,
                        'discount_percentage' => $flashSaleProduct->discount_percentage,
                        'is_in_flash_sale' => true
                    ]
                ]);
            } else {
                $discountPercentage = null;
                if ($variant->sale_price) {
                    $discountPercentage = round((($variant->listed_price - $variant->sale_price) / $variant->listed_price) * 100);
                }
                return response()->json([
                    'status' => true,
                    'data' => [
                        'listed_price' => $variant->listed_price,
                        'sale_price' => $variant->sale_price,
                        'quantity' => $variant->quantity,
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
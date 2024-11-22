<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flashSale = FlashSale::where('status', 1)
            ->where('date', now()->toDateString())
            ->where(function ($query) {
                $currentHour = now()->hour;
                $currentMinute = now()->minute;
                $query->whereRaw('? BETWEEN SUBSTRING_INDEX(time_slot, "-", 1) AND SUBSTRING_INDEX(time_slot, "-", -1)', [$currentHour])
                    ->orWhereRaw('? = SUBSTRING_INDEX(time_slot, "-", -1) AND ? < 60', [$currentHour, $currentMinute]);
            })->first();



        $flashSaleEndTime = null;
        if ($flashSale) {
            $products = [];
        }
        $products = $this->getActiveFlashSaleProducts();
        if ($flashSale) {
            $startTime = explode('-', $flashSale->time_slot)[0];
            $endTime = explode('-', $flashSale->time_slot)[1];
            $flashSaleEndTime = Carbon::parse($flashSale->date . ' ' . $endTime . ':00:00')->toDateTimeString();
        }


        return view('client.page.flashSale', compact('flashSale', 'flashSaleEndTime', 'products'));
    }

    public function getActiveFlashSaleProducts()
    {
        $currentDateTime = Carbon::now();

        // Lấy các sản phẩm đang active có trong flash sale đang diễn ra
        $products = Product::where('status', 1)
            ->whereHas('flashSaleProducts.flashSale', function ($query) use ($currentDateTime) {
                $query->where('status', 1)
                    ->where('date', $currentDateTime->toDateString())
                    ->where(function ($query) use ($currentDateTime) {
                        $currentHour = now()->hour;
                        $currentMinute = now()->minute;
                        $query->whereRaw('? BETWEEN SUBSTRING_INDEX(time_slot, "-", 1) AND SUBSTRING_INDEX(time_slot, "-", -1)', [$currentHour])
                            ->orWhereRaw('? = SUBSTRING_INDEX(time_slot, "-", -1) AND ? < 60', [$currentHour, $currentMinute]);
                    });
            })
            ->with(['flashSaleProducts' => function ($query) {
                $query->whereHas('flashSale', function ($query) {
                    $query->where('status', 1)
                        ->where('date', now()->toDateString())
                        ->where(function ($query) {
                            $currentHour = now()->hour;
                            $currentMinute = now()->minute;
                            $query->whereRaw('? BETWEEN SUBSTRING_INDEX(time_slot, "-", 1) AND SUBSTRING_INDEX(time_slot, "-", -1)', [$currentHour])
                                ->orWhereRaw('? = SUBSTRING_INDEX(time_slot, "-", -1) AND ? < 60', [$currentHour, $currentMinute]);
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
}

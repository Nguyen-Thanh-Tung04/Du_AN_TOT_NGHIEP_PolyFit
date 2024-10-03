<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{


    public function __construct() {}

    public function show($id)
    {
        $product = Product::with(['category', 'variants.color', 'variants.size'])->findOrFail($id);

        $minVariant = $product->variants->sortBy(function ($variant) {
            return $variant->sale_price ?? $variant->purchase_price;
        })->first();

        $minPurchasePrice = $minVariant->purchase_price;
        $minSalePrice = $minVariant->sale_price;

        $galleryString = str_replace("'", '"', $product->gallery);

        $galleryImages = json_decode($galleryString);

        return view('client.page.productDetail', compact('product', 'minPurchasePrice', 'minSalePrice', 'galleryImages'));
    }

    public function getVariantDetails(Request $request)
    {
        $variant = Variant::where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->where('size_id', $request->size_id)
            ->first();

        if ($variant) {
            return response()->json([
                'status' => true,
                'data' => $variant
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Variant not found'
            ]);
        }
    }
}

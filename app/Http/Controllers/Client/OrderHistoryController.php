<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.variant.product')
        ->where('user_id', auth()->id()) 
        ->get();
        return view('client.page.history', compact('orders'));
    }
    public function show($id){
        $order = Order::with('orderItems.variant.product')->findOrFail($id);
         return view('client.page.order', compact('order'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listOrder = Order::query()->orderByDesc('id')->get();
        $orderStatuses = Order::STATUS_NAMES;
        $cancelledOrder = Order::STATUS_HUY_DON_HANG;
        return view('admin.orders.index', compact('listOrder', 'orderStatuses', 'cancelledOrder'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $donHang = Order::with(['user', 'orderItems.variant.product', 'statusHistories.user',])->findOrFail($id);

        $trangThaiDonHang = Order::STATUS_NAMES;
        $trangThaiThanhToan = Order::PAYMENT_METHOD_NAMES;
        $donHang->statusHistories = $donHang->statusHistories()->orderBy('changed_at', 'desc')->get();
        return view('admin.orders.show', compact('donHang', 'trangThaiDonHang', 'trangThaiThanhToan'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::query()->findOrFail($id);
        $currentStatus = $order->status;
        $newStatus = $request->input('status');
        $statuses = array_keys(Order::STATUS_NAMES);

        // Kiểm tra nếu đơn hàng đã bị hủy thì không được thay đổi trạng thái
        if ($currentStatus === Order::STATUS_HUY_DON_HANG) {
            return redirect()->route('orders.index')->with('error', 'Đơn hàng đã bị hủy không thể thay đổi trạng thái.');
        }

        if (array_search($newStatus, $statuses) < array_search($currentStatus, $statuses)) {
            return redirect()->route('orders.index')->with('error', 'Không thể cập nhật ngược lại trạng thái.');
        }
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'previous_status' => $order->status,
            'new_status' => $request->status,
            'cancel_reason' => $request->cancel_reason,
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);

        $order->status = $newStatus;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donHang = Order::query()->findOrFail($id);
        if ($donHang && $donHang->status == Order::STATUS_HUY_DON_HANG) {
            $donHang->orderItems()->delete();

            $donHang->delete();
            return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xóa thành công.');
        }
        return redirect()->back()->with('error', 'Không thể xóa được đơn hàng');
    }
    // public function confirmCancellation(Request $request, string $id)
    // {
    //     $donHang = Order::findOrFail($id);

        
    //     $request->validate([
    //         'cancel_reason' => 'required|string|max:255',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         if ($donHang->status === Order::STATUS_CHO_XAC_NHAN_HUY) {
    //             $previousStatus = $donHang->status; // Lưu trạng thái trước khi cập nhật

    //             $donHang->update(['status' => Order::STATUS_HUY_DON_HANG]);

    //             OrderStatusHistory::create([
    //                 'order_id' => $donHang->id,
    //                 'previous_status' => $previousStatus,
    //                 'new_status' => Order::STATUS_HUY_DON_HANG,
    //                 'cancel_reason' => $request->cancel_reason, // Lưu lý do hủy
    //                 'changed_by' => auth()->id(),
    //             ]);
    //         } else {
    //             return redirect()->back()->withErrors(['msg' => 'Đơn hàng không ở trạng thái "Chờ xác nhận hủy".']);
    //         }

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->withErrors(['msg' => 'Có lỗi xảy ra trong quá trình xác nhận hủy đơn hàng: ' . $e->getMessage()]);
    //     }

    //     return redirect()->back()->with('success', 'Đã xác nhận hủy đơn hàng.');
    // }
}

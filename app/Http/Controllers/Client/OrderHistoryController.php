<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.variant.product'])
            ->where('user_id', auth()->id())
            ->get();

        // Phân loại đơn hàng
        $pendingOrders = $orders->where('status', Order::STATUS_CHO_XAC_NHAN);
        $confirmedOrders = $orders->where('status', Order::STATUS_DA_XAC_NHAN);
        $preparingOrders = $orders->where('status', Order::STATUS_DANG_CHUAN_BI);
        $shippingOrders = $orders->where('status', Order::STATUS_DANG_VAN_CHUYEN);
        $deliveredOrders = $orders->where('status', Order::STATUS_DA_GIAO_HANG);
        $cancelledOrders = $orders->where('status', Order::STATUS_HUY_DON_HANG);

        $pendingCount = $pendingOrders->count();
        $confirmedCount = $confirmedOrders->count();
        $preparingCount = $preparingOrders->count();
        $shippingCount = $shippingOrders->count();
        $deliveredCount = $deliveredOrders->count();
        $cancelledCount = $cancelledOrders->count();
        return view('client.page.history', compact(
            'orders',
            'pendingOrders',
            'confirmedOrders',
            'preparingOrders',
            'shippingOrders',
            'deliveredOrders',
            'cancelledOrders',
            'pendingCount',
            'confirmedCount',
            'preparingCount',
            'shippingCount',
            'deliveredCount',
            'cancelledCount'
        ));
    }

    public function show($id)
    {
        $order = Order::with('orderItems.variant.product')->findOrFail($id);
        return view('client.page.order', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        $donHang = Order::findOrFail($id);
        DB::beginTransaction();

        try {
            $previousStatus = $donHang->status;

            if ($request->has('huy_don_hang')) {
                if ($previousStatus !== Order::STATUS_CHO_XAC_NHAN) {
                    return redirect()->back()->with('error' , 'Không thể hủy vì đơn hàng đã chuyển trạng thái');
                }

                $donHang->update(['status' => Order::STATUS_HUY_DON_HANG]);
                OrderStatusHistory::create([
                    'order_id' => $donHang->id,
                    'previous_status' => $previousStatus,
                    'new_status' => Order::STATUS_HUY_DON_HANG,
                    'cancel_reason' => $request->cancel_reason,
                    'changed_by' => auth()->id(),
                ]);
            } elseif ($request->has('da_giao_hang')) {
                if ($previousStatus !== Order::STATUS_DANG_VAN_CHUYEN) {
                    return redirect()->back()->with('error', 'Không thể xác nhận đã nhận hàng khi nó không ở trạng thái "Đang vận chuyển".');
                }

                $donHang->update(['status' => Order::STATUS_DA_GIAO_HANG]);
                OrderStatusHistory::create([
                    'order_id' => $donHang->id,
                    'previous_status' => $previousStatus,
                    'new_status' => Order::STATUS_DA_GIAO_HANG,
                    'cancel_reason' => null,
                    'changed_by' => auth()->id(),
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error' , 'Có lỗi xảy ra trong quá trình cập nhật trạng thái đơn hàng.');
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}

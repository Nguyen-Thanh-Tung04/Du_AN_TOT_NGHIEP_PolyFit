<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\AutoCompleteOrderStatus; // Thêm dòng này

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Order::query();

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        if ($keyword = request('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('full_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('code', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $keyword . '%');
            });
        }

        if ($startDate = request('start_date')) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate = request('end_date')) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $listOrder = $query->orderByDesc('id')->paginate(request('perpage', 20));

        $orderStatuses = Order::STATUS_NAMES;
        $cancelledOrder = Order::STATUS_HUY_DON_HANG;
        $completedOrder = Order::STATUS_HOAN_THANH;

        return view('admin.orders.index', compact('listOrder', 'orderStatuses', 'cancelledOrder', 'completedOrder'));
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
    // Controller's update method
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $currentStatus = $order->status;
        $newStatus = $request->input('status');
        $statuses = array_keys(Order::STATUS_NAMES);

        if ($currentStatus === Order::STATUS_HUY_DON_HANG) {
            return redirect()->route('orders.index')->with('error', 'Đơn hàng đã bị hủy không thể thay đổi trạng thái.');
        }

        // Lấy vị trí của trạng thái hiện tại và trạng thái mới trong mảng trạng thái
        $currentIndex = array_search($currentStatus, $statuses);
        $newIndex = array_search($newStatus, $statuses);

        // Kiểm tra trạng thái mới có phải trạng thái liền kề hay không
        if ($newIndex !== $currentIndex + 1) {
            return redirect()->route('orders.index')->with('error', 'Chuyển trạng thái không hợp lệ.');
        }

        // Tạo lịch sử trạng thái
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'previous_status' => $order->status,
            'new_status' => $newStatus,
            'cancel_reason' => $request->cancel_reason ?? null,
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);

        // Cập nhật trạng thái mới
        $order->status = $newStatus;
        $order->save();

        // Gọi job tự động nếu trạng thái là "Giao hàng thành công"
        if ($newStatus == Order::STATUS_GIAO_HANG_THANH_CONG) {
            AutoCompleteOrderStatus::dispatch($order->id)->delay(now()->addSeconds(10));
        }

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
    public function exportOrders(Request $request)
    {
        $status = $request->input('status');
        $keyword = $request->input('keyword');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return Excel::download(new OrdersExport($status, $keyword, $startDate, $endDate), 'ListOrder.xlsx');
    }
}

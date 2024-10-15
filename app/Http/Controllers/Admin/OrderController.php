<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy danh sách đơn hàng và sắp xếp theo ID mới nhất
        $listOrder = Order::query()->orderByDesc('id')->get();

        // Lấy danh sách trạng thái đơn hàng từ model Order
        $orderStatuses = Order::STATUS_NAMES;

        // Lấy trạng thái hủy đơn hàng từ model Order
        $cancelledOrder = Order::STATUS_HUY_DON_HANG;

        // Truyền các biến vào view
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
        // Tìm đơn hàng theo ID, nếu không tìm thấy thì trả về lỗi
        $order = Order::query()->findOrFail($id);

        // Lấy trạng thái hiện tại của đơn hàng
        $currentStatus = $order->status;

        // Lấy trạng thái mới từ form request
        $newStatus = $request->input('status');

        // Lấy tất cả trạng thái từ model Order
        $statuses = array_keys(Order::STATUS_NAMES);

        // Kiểm tra nếu đơn hàng đã bị hủy thì không được thay đổi trạng thái
        if ($currentStatus === Order::STATUS_HUY_DON_HANG) {
            return redirect()->route('orders.index')->with('error', 'Đơn hàng đã bị hủy không thể thay đổi trạng thái.');
        }

        // Kiểm tra nếu trạng thái mới không được nằm sau trạng thái hiện tại
        if (array_search($newStatus, $statuses) < array_search($currentStatus, $statuses)) {
            return redirect()->route('orders.index')->with('error', 'Không thể cập nhật ngược lại trạng thái.');
        }
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'previous_status' => $order->status,
            'new_status' => $request->status,
            'cancel_reason' => $request->cancel_reason, // Lý do hủy (nếu có)
            'changed_by' => auth()->id(), // ID của người thay đổi
            'changed_at' => now(), // Thời gian thay đổi
        ]);

        // Cập nhật trạng thái đơn hàng
        $order->status = $newStatus;
        $order->save();

        // Trả về trang danh sách đơn hàng kèm thông báo thành công
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
    // Tính doanh thu theo tháng
    public function revenueByYear($year)
    {
        $query = $this->model->newQuery();

        return $query->selectRaw('months.month, COALESCE(SUM(orders.total), 0) as monthly_revenue')
            ->from(DB::raw('(SELECT 1 AS month
                         UNION SELECT 2
                         UNION SELECT 3
                         UNION SELECT 4
                         UNION SELECT 5
                         UNION SELECT 6
                         UNION SELECT 7
                         UNION SELECT 8
                         UNION SELECT 9
                         UNION SELECT 10
                         UNION SELECT 11
                         UNION SELECT 12) as months'))
            ->leftJoin('orders', function ($join) use ($year) {
                $join->on(DB::raw('months.month'), '=', DB::raw('MONTH(orders.created_at)'))
                    ->where('orders.payment', '=', 1)
                    ->whereYear('orders.created_at', '=', $year);
            })
            ->groupBy('months.month')
            ->orderBy('months.month')
            ->get();
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\PDF;

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
        $delivered = Order::STATUS_DA_GIAO_HANG;

        return view('admin.orders.index', compact('listOrder', 'orderStatuses', 'cancelledOrder', 'delivered'));
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
    public function exportOrders(Request $request)
    {
        $status = $request->input('status');
        $keyword = $request->input('keyword');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return Excel::download(new OrdersExport($status, $keyword, $startDate, $endDate), 'ListOrder.xlsx');
    }
    public function exportPDF($id) 
    {
        // Tạo đối tượng DomPDF
        $pdf = \App::make('dompdf.wrapper');
        
    
        // Load nội dung HTML từ phương thức print_order_convert
        $pdf->loadHTML($this->print_order_convert($id));
    
        // Trả về file PDF để tải về
        return $pdf->stream();
    }
    
    public function print_order_convert($id)
    {
        // Trả về HTML hợp lệ để tạo file PDF
        $order = Order::with(['user', 'orderItems.variant.product', 'statusHistories.user',])->findOrFail($id);

        $statusOrder = Order::STATUS_NAMES;
        $statusPayment = Order::PAYMENT_METHOD_NAMES;
        $order->statusHistories = $order->statusHistories()->orderBy('changed_at', 'desc')->get();
        // dd($order, $statusOrder, $statusPayment);
        return view('admin.orders.invoice', compact('order', 'statusOrder', 'statusPayment'));
    }

}

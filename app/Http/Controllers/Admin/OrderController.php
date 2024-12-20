<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\AutoCompleteOrderStatus;
use App\Mail\OrderCanceled;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $order = Order::with('orderItems.variant')->findOrFail($id);
        $currentStatus = $order->status;
        $newStatus = $request->input('status');
        $statuses = array_keys(Order::STATUS_NAMES);

        if ($currentStatus == Order::STATUS_HUY_DON_HANG) {
            return redirect()->route('orders.index')->with('error', 'Đơn hàng này đã bị hủy, không thể chuyển trạng thái khác.');
        }

        // Kiểm tra nếu đơn hàng đã bị hủy trước đó
        if ($currentStatus == Order::STATUS_HUY_DON_HANG && $newStatus == Order::STATUS_HUY_DON_HANG) {
            return redirect()->route('orders.index')->with('error', 'Đơn hàng này đã bị hủy trước đó.');
        }

        // Kiểm tra trạng thái không quay ngược lại trạng thái trước đó
        if (array_search($newStatus, $statuses) < array_search($currentStatus, $statuses)) {
            return redirect()->route('orders.index')->with('error', 'Không thể cập nhật trạng thái lùi về trạng thái trước đó.');
        }

        DB::beginTransaction();

        try {
            if ($newStatus == Order::STATUS_HUY_DON_HANG) {
                if ($currentStatus !== Order::STATUS_CHO_XAC_NHAN && $currentStatus !== Order::STATUS_DA_XAC_NHAN) {
                    return redirect()->route('orders.index')->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái "Chờ xác nhận" hoặc "Đã xác nhận".');
                }

                foreach ($order->orderItems as $item) {
                    $variant = $item->variant;
                    $variant->update(['quantity' => $variant->quantity + $item->quantity]);
                }

                if ($order->voucher) {
                    $voucher = $order->voucher;
                    $voucher->update(['quantity' => $voucher->quantity + 1]);
                    $voucher->users()->detach($order->user_id);
                }

                $order->update(['status' => Order::STATUS_HUY_DON_HANG]);

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'previous_status' => $currentStatus,
                    'new_status' => Order::STATUS_HUY_DON_HANG,
                    'cancel_reason' => $request->cancel_reason,
                    'changed_by' => auth()->id(),
                ]);

                // Gửi email thông báo hủy đơn hàng
                Mail::to($order->user->email)->queue(new OrderCanceled($order));
            } else {
                // Kiểm tra trạng thái liền kề
                $currentIndex = array_search($currentStatus, $statuses);
                $newIndex = array_search($newStatus, $statuses);

                if ($newIndex === false || abs($newIndex - $currentIndex) !== 1) {
                    return redirect()->route('orders.index')->with('error', 'Chỉ có thể chuyển sang trạng thái liền kề.');
                }

                $order->update(['status' => $newStatus]);
                $order->save(); // Lưu lại thay đổi trạng thái thanh toán

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'previous_status' => $currentStatus,
                    'new_status' => $newStatus,
                    'cancel_reason' => $request->cancel_reason ?? null,
                    'changed_by' => auth()->id(),
                ]);
            }

            if ($newStatus == Order::STATUS_GIAO_HANG_THANH_CONG) {
                AutoCompleteOrderStatus::dispatch($order->id)->delay(now()->addSeconds(20));
            }

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')->with('error', 'Có lỗi xảy ra trong quá trình cập nhật trạng thái đơn hàng.');
        }
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
        $pdf = App::make('dompdf.wrapper');


        // Load nội dung HTML từ phương thức print_order_convert
        $pdf->loadHTML($this->print_order_convert($id));

        // Trả về file PDF để tải về
        return $pdf->download();
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
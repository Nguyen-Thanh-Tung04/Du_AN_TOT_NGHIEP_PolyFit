<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct() {

    }
    public function index()
    {
        $config = $this->config();
        $template = 'admin.dashboard.home.index';

        // Lấy tháng và năm hiện tại
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Truy vấn tổng số đơn hàng đã thanh toán trong tháng này
        $totalOrders = DB::table('orders')
            ->where('status', 5) // Chỉ tính những đơn hàng đã thanh toán
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Truy vấn tổng số đơn hàng đã hủy trong tháng này
        $canceledOrders = DB::table('orders')
            ->where('status', 6) // Đơn hàng đã hủy
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Tính tỷ lệ phần trăm của đơn hàng đã hủy
        $cancellationRate = ($totalOrders > 0)
            ? ($canceledOrders / $totalOrders) * 100
            : 0;
        $cancellationRate = round($cancellationRate, 2) . '%';

        // Truy vấn tổng đơn hàng và doanh thu trong tháng này
        $monthlyOrders = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue') // Giả sử bạn có cột 'total_price' lưu trữ doanh thu
            )
            ->where('status', 5) // Chỉ tính những đơn hàng đã thanh toán
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Truy vấn tổng số khách hàng truy cập
        $totalCustomers = DB::table('users')->count();

        // Truy vấn 10 đơn hàng mới nhất trong tháng này
        $latestOrders = DB::table('orders')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian mới nhất
            ->limit(10) // Lấy 10 đơn hàng mới nhất
            ->get();

        // Nếu không có dữ liệu
        if ($monthlyOrders->isEmpty()) {
            return view('admin.dashboard.layout', compact('template', 'config', 'totalOrders', 'canceledOrders', 'cancellationRate', 'totalCustomers', 'latestOrders'));
        }

        // Lấy dữ liệu tháng mới nhất
        $latestMonthData = $monthlyOrders->last();
        $latestMonthOrders = $latestMonthData->total_orders;
        $latestMonthRevenue = $latestMonthData->total_revenue;
        $latestMonth = $latestMonthData->month;

        // Tính tổng đơn hàng và doanh thu của tháng trước (trường hợp tháng hiện tại có dữ liệu)
        $previousMonthOrders = DB::table('orders')
            ->where('status', 5) // Chỉ tính đơn hàng đã thanh toán
            ->whereMonth('created_at', $currentMonth - 1)
            ->whereYear('created_at', $currentYear)
            ->count();

        $previousMonthRevenue = DB::table('orders')
            ->where('status', 5) // Chỉ tính đơn hàng đã thanh toán
            ->whereMonth('created_at', $currentMonth - 1)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        // Tính tỷ lệ tăng trưởng đơn hàng
        $growth = ($previousMonthOrders > 0)
            ? (($latestMonthOrders - $previousMonthOrders) / $previousMonthOrders) * 100
            : ($latestMonthOrders > 0 ? 100 : 0);
        $growth = min($growth, 100);

        // Tính tỷ lệ tăng trưởng doanh thu
        $revenueGrowth = ($previousMonthRevenue > 0)
            ? (($latestMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100
            : ($latestMonthRevenue > 0 ? 100 : 0);
        $revenueGrowth = min($revenueGrowth, 100);

        // Chuẩn bị dữ liệu kết quả
        $results = [
            [
                'month' => $latestMonth,
                'total_orders' => $latestMonthOrders,
                'total_revenue' => round($latestMonthRevenue, 2),
                'growth' => round($growth, 2) . '%', // Tăng trưởng đơn hàng
                'revenue_growth' => round($revenueGrowth, 2) . '%' // Tăng trưởng doanh thu
            ]
        ];

        // Trả về view với dữ liệu
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'results', // Truyền dữ liệu đã tính toán vào view
            'totalOrders', // Truyền tổng số đơn hàng vào view
            'canceledOrders', // Truyền số đơn hàng đã hủy vào view
            'cancellationRate', // Truyền tỷ lệ hủy vào view
            'totalCustomers', // Tổng khách hàng
            'latestOrders' // 10 đơn hàng mới nhất
        ));
    }
    function statistical_sale(Request $request) {
        $date_start = $request->input('date_start');
        $end_date = $request->input('end_date');
        $choose_time = strtolower($request->input('choose_time')); // Nhận giá trị thời gian từ input (day, week, month, year)

        // Kiểm tra và xử lý theo yêu cầu: ngày, tuần, tháng, năm
        switch ($choose_time) {
            case 'day':
                $group_by = DB::raw("DATE(orders.created_at)");
                break;
            case 'week':
                $group_by = DB::raw("WEEK(orders.created_at)");
                break;
            case 'month':
                $group_by = DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m')");
                break;
            case 'year':
                $group_by = DB::raw("YEAR(orders.created_at)");
                break;
            default:
                // Mặc định là nhóm theo ngày nếu không có lựa chọn hợp lệ
                $group_by = DB::raw("DATE(orders.created_at)");
                break;
        }

        // Sử dụng Eloquent để truy vấn dữ liệu
        $results = DB::table('orders')
            ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                $group_by, // Nhóm theo ngày, tuần, tháng, năm
                DB::raw('COUNT(DISTINCT orders.id) AS so_luong_don_hang'),
                DB::raw('SUM(order_items.quantity) AS so_luong_ban_ra'),
                DB::raw('SUM(orders.total_price) AS doanh_thu')
            )
            ->whereBetween(DB::raw('DATE(orders.created_at)'), [$date_start, $end_date]) // Lọc theo khoảng thời gian
            ->where('orders.status', '=', 5) // Chỉ lấy đơn hàng có status = 5
            ->groupBy($group_by) // Nhóm theo thời gian tương ứng
            ->get();

        dd($results);
        // Trả về view với dữ liệu
//        return view('statistical_sale_view', ['results' => $results]);
    }

//    public function statistical_sale(Request $request)
//    {
//        // Lấy dữ liệu từ request
//
//
//        // Kiểm tra xem các biến có giá trị hợp lệ hay không
//        if (!$date_start || !$end_date || !$choose_time) {
//            return response()->json(['error' => 'Thiếu thông tin cần thiết.'], 400);
//        }
//
//        // Khởi tạo biến @row
//        DB::statement('SET @row = -1');
//
//        // Tạo dãy số từ 0 đến 1000
//        $dates = DB::table(DB::raw('(
//        SELECT DATE_ADD(?, INTERVAL seq DAY) AS date
//        FROM (
//            SELECT @row := @row + 1 AS seq
//            FROM (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
//                  UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
//                  UNION ALL SELECT 8 UNION ALL SELECT 9) t1,
//            (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
//                  UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
//                  UNION ALL SELECT 8 UNION ALL SELECT 9) t2,
//            (SELECT @row := -1) t3
//            LIMIT 1000
//        ) seq_table
//        WHERE DATE_ADD(?, INTERVAL seq DAY) <= ?
//    ) AS dates'))
//            ->select(DB::raw(($choose_time == 'MONTH' ? "DATE_FORMAT(date, '%Y-%m')" : "$choose_time(date)") . " AS date"))
//            ->leftJoin('orders', DB::raw('DATE(orders.created_at)'), '=', 'dates.date')
//            ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
//            ->where('orders.status', 5)
//            ->groupBy(DB::raw($choose_time == 'MONTH' ? "DATE_FORMAT(date, '%Y-%m')" : "$choose_time(date)"))
//            ->selectRaw('COUNT(DISTINCT orders.id) AS count_Order, SUM(order_items.quantity) AS quantity_Out, SUM(orders.total_price) AS revenue')
//            ->setBindings([$date_start, $date_start, $end_date]) // Đảm bảo số lượng tham số khớp
//            ->get();
//
//        return response()->json($dates); // Trả về dữ liệu
//    }
//



    private function config() {
        return [
            'js' => [
                'admin/js/plugins/flot/jquery.flot.js',
                'admin/js/plugins/flot/jquery.flot.tooltip.min.js',
                'admin/js/plugins/flot/jquery.flot.spline.js',
                'admin/js/plugins/flot/jquery.flot.resize.js',
                'admin/js/plugins/flot/jquery.flot.pie.js',
                'admin/js/plugins/flot/jquery.flot.symbol.js',
                'admin/js/plugins/flot/jquery.flot.time.js',
                'admin/js/plugins/peity/jquery.peity.min.js',
                'admin/js/demo/peity-demo.js',
                'admin/js/inspinia.js',
                'admin/js/plugins/pace/pace.min.js',
                'admin/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
                'admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
                'admin/js/plugins/easypiechart/jquery.easypiechart.js',
                'admin/js/plugins/sparkline/jquery.sparkline.min.js',
                'admin/js/demo/sparkline-demo.js',
            ],
            'css' => [
                'admin/css/animate.css',
                'admin/css/style.css',
                'admin/css/customize.css',
                'admin/js/jquery-3.1.1.min.js',
            ]
        ];
    }
}

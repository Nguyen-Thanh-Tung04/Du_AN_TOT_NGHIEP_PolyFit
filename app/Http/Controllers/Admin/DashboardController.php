<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
//            ->where('status', 5) // Chỉ tính những đơn hàng đã thanh toán
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
        $latestUsers = DB::table('users')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian mới nhất
            ->limit(10) // Lấy 10 đơn hàng mới nhất
            ->get();

        // Nếu không có dữ liệu
        if ($monthlyOrders->isEmpty()) {
            return view('admin.dashboard.layout', compact('template', 'config', 'totalOrders', 'canceledOrders', 'cancellationRate', 'totalCustomers', 'latestOrders', 'latestUsers'));
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
//        dd($latestUser);
//        dd($results);

        // Trả về view với dữ liệu
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'results', // Truyền dữ liệu đã tính toán vào view
            'totalOrders', // Truyền tổng số đơn hàng vào view
            'canceledOrders', // Truyền số đơn hàng đã hủy vào view
            'cancellationRate', // Truyền tỷ lệ hủy vào view
            'totalCustomers', // Tổng khách hàng
            'latestOrders', // 10 đơn hàng mới nhất
            'latestUsers'
        ));
    }

    public function statistical_sale(Request $request)
    {
        $config = $this->config();
        $template = 'admin.dashboard.home.chart';
        $template1 = 'admin.dashboard.home.index';

        // Lấy tháng và năm hiện tại
        $currentMonth = date('m');
        $currentYear = date('Y');
        $date_start = $request->input('date_start');
        $end_date = $request->input('end_date');
        $choose_time = strtolower($request->input('choose_time'));

        // Kiểm tra nếu ngày bắt đầu hoặc ngày kết thúc chưa được nhập
        $results_one = collect();
        // Truy vấn 10 đơn hàng mới nhất trong tháng này
        $latestOrders = DB::table('orders')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian mới nhất
            ->limit(10) // Lấy 10 đơn hàng mới nhất
            ->get();

        $latestUsers = DB::table('users')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian mới nhất
            ->limit(10) // Lấy 10 đơn hàng mới nhất
            ->get();
        $totalOrders = DB::table('orders')
//            ->where('status', 5) // Chỉ tính những đơn hàng đã thanh toán
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


        // Nếu không có dữ liệu
        if ($monthlyOrders->isEmpty()) {
            return view('admin.dashboard.layout', compact('template', 'config', 'totalOrders', 'canceledOrders', 'cancellationRate', 'totalCustomers', 'latestOrders', 'latestUsers'));
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
        if (empty($date_start) || empty($end_date)) {
            // Thông báo lỗi nếu chưa nhập ngày
            $errorMessage = 'Vui lòng nhập ngày bắt đầu và ngày kết thúc!';
//            return view('admin.dashboard.home.index', compact('template', 'config','results', 'totalOrders','canceledOrders','cancellationRate','totalCustomers', 'results_one', 'latestOrders', 'latestUsers', 'errorMessage'));
            return view('admin.dashboard.layout', compact(
                'template1',
                'config',
                'results', // Truyền dữ liệu đã tính toán vào view
                'totalOrders', // Truyền tổng số đơn hàng vào view
                'canceledOrders', // Truyền số đơn hàng đã hủy vào view
                'cancellationRate', // Truyền tỷ lệ hủy vào view
                'totalCustomers', // Tổng khách hàng
                'latestOrders', // 10 đơn hàng mới nhất
                'latestUsers',
                'errorMessage'
            ));
        }
        // Tạo danh sách các mốc thời gian từ date_start đến end_date
        $dates = collect();
        switch ($choose_time) {
            case 'day':
                for ($date = Carbon::parse($date_start); $date->lte(Carbon::parse($end_date)); $date->addDay()) {
                    $dates->push($date->format('Y-m-d'));
                }
                break;
            case 'week':
                for ($date = Carbon::parse($date_start)->startOfWeek(); $date->lte(Carbon::parse($end_date)->endOfWeek()); $date->addWeek()) {
                    $dates->push($date->format('o-W')); // Định dạng Y-W cho tuần
                }
                break;
            case 'month':
                for ($date = Carbon::parse($date_start)->startOfMonth(); $date->lte(Carbon::parse($end_date)->endOfMonth()); $date->addMonth()) {
                    $dates->push($date->format('Y-m'));
                }
                break;
            case 'year':
                for ($date = Carbon::parse($date_start)->startOfYear(); $date->lte(Carbon::parse($end_date)->endOfYear()); $date->addYear()) {
                    $dates->push($date->format('Y'));
                }
                break;
        }

// Truy vấn dữ liệu với Eloquent
        $query = DB::table('orders')
            ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                DB::raw($choose_time === 'week' ? "CONCAT(YEAR(orders.created_at), '-', LPAD(WEEK(orders.created_at, 3), 2, '0')) AS date" : // Chọn định dạng cho tuần
                    ($choose_time === 'month' ? "DATE_FORMAT(orders.created_at, '%Y-%m') AS date" :
                        ($choose_time === 'year' ? "YEAR(orders.created_at) AS date" : "DATE(orders.created_at) AS date"))),
                DB::raw('COUNT(DISTINCT CASE WHEN orders.status = 5 THEN orders.id END) AS so_luong_don_hang'), // Đếm đơn hàng đã đặt thành công
                DB::raw('SUM(CASE WHEN orders.status = 5 THEN order_items.quantity ELSE 0 END) AS so_luong_ban_ra'), // Số lượng bán ra cho đơn hàng đã đặt thành công
                DB::raw('SUM(CASE WHEN orders.status = 5 THEN orders.total_price ELSE 0 END) AS doanh_thu'), // Doanh thu từ đơn hàng đã đặt thành công
                DB::raw('COUNT(DISTINCT CASE WHEN orders.status = 6 THEN orders.id END) AS tong_so_don_hang_huy') // Đếm đơn hàng đã hủy
            )
            ->whereBetween(DB::raw('DATE(orders.created_at)'), [$date_start, $end_date])
            ->groupBy(DB::raw($choose_time === 'month' ? "DATE_FORMAT(orders.created_at, '%Y-%m')" :
                ($choose_time === 'week' ? "CONCAT(YEAR(orders.created_at), '-', LPAD(WEEK(orders.created_at, 3), 2, '0'))" : // Nhóm theo tuần
                    ($choose_time === 'year' ? "YEAR(orders.created_at)" : "DATE(orders.created_at)"))));

// Lấy kết quả và chuyển sang dạng hiển thị đầy đủ mốc thời gian
        $results_one = $dates->map(function ($date) use ($query, $choose_time) {
            $dateQuery = clone $query;

            if ($choose_time === 'month') {
                $dateResult = $dateQuery->where(DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m')"), $date)->first();
            } elseif ($choose_time === 'week') {
                $dateResult = $dateQuery->where(DB::raw("CONCAT(YEAR(orders.created_at), '-', LPAD(WEEK(orders.created_at, 3), 2, '0'))"), $date)->first(); // So sánh theo định dạng Y-W
            } elseif ($choose_time === 'year') {
                $dateResult = $dateQuery->where(DB::raw("YEAR(orders.created_at)"), $date)->first();
            } else {
                $dateResult = $dateQuery->where(DB::raw("DATE(orders.created_at)"), $date)->first();
            }

            return [
                'date' => $date,
                'so_luong_don_hang' => $dateResult->so_luong_don_hang ?? 0,
                'so_luong_ban_ra' => $dateResult->so_luong_ban_ra ?? 0,
                'doanh_thu' => $dateResult->doanh_thu ?? 0,
                'tong_so_don_hang_huy' => $dateResult->tong_so_don_hang_huy ?? 0, // Số lượng đơn hàng đã hủy
            ];
        });

//        $dates = collect();
//        switch ($choose_time) {
//            case 'day':
//                for ($date = Carbon::parse($date_start); $date->lte(Carbon::parse($end_date)); $date->addDay()) {
//                    $dates->push($date->format('Y-m-d'));
//                }
//                break;
//            case 'week':
//                for ($date = Carbon::parse($date_start)->startOfWeek(); $date->lte(Carbon::parse($end_date)->endOfWeek()); $date->addWeek()) {
//                    $dates->push($date->format('o-W'));
//                }
//                break;
//            case 'month':
//                for ($date = Carbon::parse($date_start)->startOfMonth(); $date->lte(Carbon::parse($end_date)->endOfMonth()); $date->addMonth()) {
//                    $dates->push($date->format('Y-m'));
//                }
//                break;
//            case 'year':
//                for ($date = Carbon::parse($date_start)->startOfYear(); $date->lte(Carbon::parse($end_date)->endOfYear()); $date->addYear()) {
//                    $dates->push($date->format('Y'));
//                }
//                break;
//        }
//
//        // Truy vấn dữ liệu với Eloquent
//        $query = DB::table('orders')
//            ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
//            ->select(
//                DB::raw($choose_time === 'week' ? "YEARWEEK(orders.created_at, 3) AS date" :
//                    ($choose_time === 'month' ? "DATE_FORMAT(orders.created_at, '%Y-%m') AS date" :
//                        ($choose_time === 'year' ? "YEAR(orders.created_at) AS date" : "DATE(orders.created_at) AS date"))),
//                DB::raw('COUNT(DISTINCT CASE WHEN orders.status = 5 THEN orders.id END) AS so_luong_don_hang'), // Đếm đơn hàng đã đặt thành công
//                DB::raw('SUM(CASE WHEN orders.status = 5 THEN order_items.quantity ELSE 0 END) AS so_luong_ban_ra'), // Số lượng bán ra cho đơn hàng đã đặt thành công
//                DB::raw('SUM(CASE WHEN orders.status = 5 THEN orders.total_price ELSE 0 END) AS doanh_thu'), // Doanh thu từ đơn hàng đã đặt thành công
//                DB::raw('COUNT(DISTINCT CASE WHEN orders.status = 6 THEN orders.id END) AS tong_so_don_hang_huy') // Đếm đơn hàng đã hủy
//            )
//            ->whereBetween(DB::raw('DATE(orders.created_at)'), [$date_start, $end_date])
//            ->groupBy(DB::raw($choose_time === 'month' ? "DATE_FORMAT(orders.created_at, '%Y-%m')" :
//                ($choose_time === 'week' ? "YEARWEEK(orders.created_at, 3)" :
//                    ($choose_time === 'year' ? "YEAR(orders.created_at)" : "DATE(orders.created_at)"))));
////        dd($results_one);die();
//        // Lấy kết quả và chuyển sang dạng hiển thị đầy đủ mốc thời gian
//        $results_one = $dates->map(function ($date) use ($query, $choose_time) {
//            $dateQuery = clone $query;
//
//            if ($choose_time === 'month') {
//                $dateResult = $dateQuery->where(DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m')"), $date)->first();
//            } elseif ($choose_time === 'week') {
//                $dateResult = $dateQuery->where(DB::raw("YEARWEEK(orders.created_at, 3)"), $date)->first();
//            } elseif ($choose_time === 'year') {
//                $dateResult = $dateQuery->where(DB::raw("YEAR(orders.created_at)"), $date)->first();
//            } else {
//                $dateResult = $dateQuery->where(DB::raw("DATE(orders.created_at)"), $date)->first();
//            }
//            return [
//                'date' => $date,
//                'so_luong_don_hang' => $dateResult->so_luong_don_hang ?? 0,
//                'so_luong_ban_ra' => $dateResult->so_luong_ban_ra ?? 0,
//                'doanh_thu' => $dateResult->doanh_thu ?? 0,
//                'tong_so_don_hang_huy' => $dateResult->tong_so_don_hang_huy ?? 0, // Số lượng đơn hàng đã hủy
//            ];
//        });
//        dd($results_one);

//        dd($results_one);die();
        // Trả về view với dữ liệu
        $successMessage = 'Lọc dữ liệu thành công!';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'results', // Truyền dữ liệu đã tính toán vào view
            'totalOrders', // Truyền tổng số đơn hàng vào view
            'canceledOrders', // Truyền số đơn hàng đã hủy vào view
            'cancellationRate', // Truyền tỷ lệ hủy vào view
            'totalCustomers', // Tổng khách hàng
            'latestOrders', // 10 đơn hàng mới nhất
            'latestUsers',
            'results_one',
            'successMessage'

        ));
    }



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

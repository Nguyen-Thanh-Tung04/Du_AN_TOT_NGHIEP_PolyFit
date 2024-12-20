<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatPrivateModel;
use Carbon\Carbon;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct() {}
    public function index()
    {
        $config = $this->config();
        $template = 'admin.dashboard.home.index';

        // Lấy tháng và năm hiện tại
        $currentDate = Carbon::today();
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Truy vấn tổng số đơn chờ xác nhận trong tháng hiện tại
        $totalProduct = DB::table('products')
            ->count();

        // Truy vấn tổng số đơn chờ xác nhận trong tháng hiện tại
        $totalOrdersConfirm = DB::table('orders')
            ->where('status', 1) // Đơn hàng chờ xác nhận
            ->whereDate('created_at', $currentDate)
            ->count();

        // Truy vấn tổng số đơn hàng đã hoàn thành
        $totalOrdersCancel = DB::table('orders')
            ->where('status', 7) // Đơn hàng đã hoàn thành
            ->whereDate('created_at', $currentDate)
            ->count();

        // Truy vấn tổng đơn hàng và doanh thu trong tháng này
        $dailyRevenue = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->where('status', 6)
            ->whereDate('created_at', $currentDate)
            ->groupBy('date')
            ->first();

        // Truy vấn 10 đơn hàng mới nhất trong tháng này
        $latestOrders = DB::table('orders')
            ->where('status', 1)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian mới nhất
            ->limit(5) // Lấy 10 đơn hàng mới nhất
            ->get();

        $orderStatus = DB::table('orders')
            ->select('status', DB::raw('count(*) as total'))
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('status')
            ->get();

        $totalCustomers = DB::table('users')
            ->where('user_catalogue_id', 3)
            ->count();

        $totalStaff = DB::table('users')
            ->where('user_catalogue_id', 2)
            ->count();

        $grossProfitToday = DB::table('order_items')
            ->join('variants', 'order_items.variant_id', '=', 'variants.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 6) // Chỉ tính đơn hàng đã thanh toán
            ->whereDate('order_items.created_at', $currentDate) // Lọc theo ngày hiện tại
            ->select(DB::raw('SUM((order_items.price - variants.purchase_price) * order_items.quantity) as total_gross_profit'))
            ->value('total_gross_profit'); // Trả về tổng lợi nhuận gộp


        // Truy vấn lợi nhuận gộp tháng 
        $grossProfit = DB::table('order_items')
            ->join('variants', 'order_items.variant_id', '=', 'variants.id')
            ->join('products', 'variants.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('colors', 'variants.color_id', '=', 'colors.id')
            ->join('sizes', 'variants.size_id', '=', 'sizes.id')
            ->select(
                DB::raw('SUM((order_items.price - variants.purchase_price) * order_items.quantity) as gross_profit'),
                DB::raw('order_items.variant_id, SUM(order_items.quantity) as total_quantity'),
                'products.name as product_name',
                'colors.name as color_name', // Chọn tên màu sắc từ bảng colors
                'sizes.name as size_name', // Chọn tên kích thước từ bảng sizes
                DB::raw('DATE_FORMAT(order_items.created_at, "%d/%m/%Y") as date') // Lấy ngày, tháng và năm từ created_at
            )
            ->where('orders.status', 6) // Chỉ tính đơn hàng đã thanh toán
            ->whereMonth('order_items.created_at', $currentMonth)
            ->whereYear('order_items.created_at', $currentYear)
            ->groupBy('order_items.variant_id', 'products.name', 'colors.name', 'sizes.name', 'date') // Nhóm theo variant_id, tên sản phẩm, tên màu sắc, tên kích thước, và ngày
            ->orderBy('gross_profit', 'desc') // Sắp xếp theo lợi nhuận gộp
            ->get();

        // Truy vấn sản phẩm bán chạy

        $bestSellingProducts = DB::table('order_items')
            ->join('variants', 'order_items.variant_id', '=', 'variants.id')
            ->join('products', 'variants.product_id', '=', 'products.id') // Liên kết sản phẩm
            ->join('orders', 'order_items.order_id', '=', 'orders.id') // Liên kết đơn hàng
            ->join('colors', 'variants.color_id', '=', 'colors.id') // Liên kết màu sắc
            ->join('sizes', 'variants.size_id', '=', 'sizes.id') // Liên kết kích thước
            ->select(
                DB::raw('
            SUM(order_items.quantity) as total_quantity
        '),
                'order_items.variant_id', // ID của biến thể
                'products.name as product_name', // Tên sản phẩm
                'colors.name as color_name', // Tên màu sắc
                'sizes.name as size_name', // Tên kích thước
                DB::raw('
            DATE_FORMAT(order_items.created_at, "%d/%m/%Y") as sale_date
        ') // Ngày bán
            )
            ->where('orders.status', 6) // Chỉ tính các đơn hàng đã thanh toán
            ->whereMonth('order_items.created_at', $currentMonth)
            ->whereYear('order_items.created_at', $currentYear)
            ->groupBy(
                'order_items.variant_id',
                'products.name',
                'colors.name',
                'sizes.name',
                DB::raw('DATE_FORMAT(order_items.created_at, "%d/%m/%Y")')
            )
            ->orderBy('total_quantity', 'desc') // Sắp xếp theo số lượng bán
            ->take(10)
            ->get();

        $monthlyOrders = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->where('status', 6) // Đơn hàng đã thanh toán
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Trả về view với dữ liệu
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'totalProduct',
            'bestSellingProducts',
            'dailyRevenue',
            'monthlyOrders',
            'totalCustomers',
            'totalStaff',
            'totalOrdersConfirm', // Truyền tổng số đơn hàng vào view
            'totalOrdersCancel',
            'latestOrders', // 10 đơn hàng mới nhất
            'orderStatus', // Trạng thái đơn hàng
            'grossProfit',
            'grossProfitToday'
        ));
    }


    public function statistical_sale(Request $request)
    {
        $config = $this->config();
        $template = 'admin.dashboard.home.chart';
        $template1 = 'admin.dashboard.home.index';

        // Lấy tháng và năm hiện tại
        $currentDate = Carbon::today();
        $currentMonth = date('m');
        $currentYear = date('Y');
        $date_start = $request->input('date_start');
        $end_date = $request->input('end_date');
        $choose_time = strtolower($request->input('choose_time'));

        // Kiểm tra nếu ngày bắt đầu hoặc ngày kết thúc chưa được nhập
        $results_one = collect();

        // Truy vấn tổng số đơn chờ xác nhận trong tháng hiện tại
        $totalProduct = DB::table('products')
            ->count();

        // Truy vấn tổng số đơn chờ xác nhận trong tháng hiện tại
        $totalOrdersConfirm = DB::table('orders')
            ->where('status', 1) // Đơn hàng chờ xác nhận
            ->whereDate('created_at', $currentDate)
            ->count();

        // Truy vấn tổng số đơn hàng đã hoàn thành
        $totalOrdersCancel = DB::table('orders')
            ->where('status', 7) // Đơn hàng đã hoàn thành
            ->whereDate('created_at', $currentDate)
            ->count();

        // Truy vấn tổng đơn hàng và doanh thu trong tháng này
        $dailyRevenue = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->where('status', 6)
            ->whereDate('created_at', $currentDate)
            ->groupBy('date')
            ->first();

        // Truy vấn 10 đơn hàng mới nhất trong tháng này
        $latestOrders = DB::table('orders')
            ->where('status', 1)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian mới nhất
            ->limit(5) // Lấy 10 đơn hàng mới nhất
            ->get();

        $orderStatus = DB::table('orders')
            ->select('status', DB::raw('count(*) as total'))
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('status')
            ->get();

        $totalCustomers = DB::table('users')
            ->where('user_catalogue_id', 3)
            ->count();

        $totalStaff = DB::table('users')
            ->where('user_catalogue_id', 2)
            ->count();

        $grossProfitToday = DB::table('order_items')
            ->join('variants', 'order_items.variant_id', '=', 'variants.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 6) // Chỉ tính đơn hàng đã thanh toán
            ->whereDate('order_items.created_at', $currentDate) // Lọc theo ngày hiện tại
            ->select(DB::raw('SUM((order_items.price - variants.purchase_price) * order_items.quantity) as total_gross_profit'))
            ->value('total_gross_profit'); // Trả về tổng lợi nhuận gộp
        $monthlyOrders = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->where('status', 6) // Đơn hàng đã thanh toán
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

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
                    ($choose_time === 'month' ? "DATE_FORMAT(orders.created_at, '%Y-%m') AS date" : ($choose_time === 'year' ? "YEAR(orders.created_at) AS date" : "DATE(orders.created_at) AS date"))),
                DB::raw('COUNT(DISTINCT CASE WHEN orders.status = 6 THEN orders.id END) AS total_orders'), // Đếm đơn hàng đã đặt thành công
                DB::raw('SUM(CASE WHEN orders.status = 6 THEN order_items.quantity ELSE 0 END) AS quantity_sold'), // Số lượng bán ra cho đơn hàng đã đặt thành công
                DB::raw('SUM(CASE WHEN orders.status = 6 THEN orders.total_price ELSE 0 END) AS revenue'), // Doanh thu từ đơn hàng đã đặt thành công
                DB::raw('COUNT(DISTINCT CASE WHEN orders.status = 7 THEN orders.id END) AS total_canceled_orders ') // Đếm đơn hàng đã hủy
            )
            ->whereBetween(DB::raw('DATE(orders.created_at)'), [$date_start, $end_date])
            ->groupBy(DB::raw($choose_time === 'month' ? "DATE_FORMAT(orders.created_at, '%Y-%m')" : ($choose_time === 'week' ? "CONCAT(YEAR(orders.created_at), '-', LPAD(WEEK(orders.created_at, 3), 2, '0'))" : // Nhóm theo tuần
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
                'total_orders' => $dateResult->total_orders ?? 0,
                'quantity_sold' => $dateResult->quantity_sold ?? 0,
                'revenue' => $dateResult->revenue ?? 0,
                'total_canceled_orders' => $dateResult->total_canceled_orders ?? 0, // Số lượng đơn hàng đã hủy
            ];
        });
        // dd($results_one);
        // Truy vấn lợi nhuận gộp
        $grossProfit = DB::table('order_items')
            ->join('variants', 'order_items.variant_id', '=', 'variants.id')
            ->join('products', 'variants.product_id', '=', 'products.id') // Giả sử variants có trường product_id để liên kết với bảng products
            ->join('orders', 'order_items.order_id', '=', 'orders.id') // Join bảng orders để lấy trạng thái
            ->join('colors', 'variants.color_id', '=', 'colors.id') // Join với bảng colors để lấy tên màu sắc
            ->join('sizes', 'variants.size_id', '=', 'sizes.id') // Join với bảng sizes để lấy tên kích thước
            ->select(
                DB::raw('SUM((order_items.price - variants.purchase_price) * order_items.quantity) as gross_profit'),
                DB::raw('order_items.variant_id, SUM(order_items.quantity) as total_quantity'),
                'products.name as product_name', // Chọn tên sản phẩm từ bảng products
                'colors.name as color_name', // Chọn tên màu sắc từ bảng colors
                'sizes.name as size_name', // Chọn tên kích thước từ bảng sizes
                DB::raw('DATE_FORMAT(order_items.created_at, "%d/%m/%Y") as date') // Lấy ngày, tháng và năm từ created_at
            )
            ->where('orders.status', 6) // Chỉ tính đơn hàng đã thanh toán
            ->whereMonth('order_items.created_at', $currentMonth)
            ->whereYear('order_items.created_at', $currentYear)
            ->groupBy('order_items.variant_id', 'products.name', 'colors.name', 'sizes.name', 'date') // Nhóm theo variant_id, tên sản phẩm, tên màu sắc, tên kích thước, và ngày
            ->orderBy('gross_profit', 'desc') // Sắp xếp theo lợi nhuận gộp
            ->get();

        $bestSellingProducts = DB::table('order_items')
            ->join('variants', 'order_items.variant_id', '=', 'variants.id')
            ->join('products', 'variants.product_id', '=', 'products.id') // Liên kết sản phẩm
            ->join('orders', 'order_items.order_id', '=', 'orders.id') // Liên kết đơn hàng
            ->join('colors', 'variants.color_id', '=', 'colors.id') // Liên kết màu sắc
            ->join('sizes', 'variants.size_id', '=', 'sizes.id') // Liên kết kích thước
            ->select(
                DB::raw('
            SUM(order_items.quantity) as total_quantity
        '),
                'order_items.variant_id', // ID của biến thể
                'products.name as product_name', // Tên sản phẩm
                'colors.name as color_name', // Tên màu sắc
                'sizes.name as size_name', // Tên kích thước
                DB::raw('
            DATE_FORMAT(order_items.created_at, "%d/%m/%Y") as sale_date
        ') // Ngày bán
            )
            ->where('orders.status', 6) // Chỉ tính các đơn hàng đã thanh toán
            ->whereMonth('order_items.created_at', $currentMonth)
            ->whereYear('order_items.created_at', $currentYear)
            ->groupBy(
                'order_items.variant_id',
                'products.name',
                'colors.name',
                'sizes.name',
                DB::raw('DATE_FORMAT(order_items.created_at, "%d/%m/%Y")')
            )
            ->orderBy('total_quantity', 'desc') // Sắp xếp theo số lượng bán
            ->take(10)
            ->get();
        // dd($grossProfit);

        $successMessage = 'Lọc dữ liệu thành công!';


        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'monthlyOrders',
            'results_one',
            'grossProfit',
            'totalProduct',
            'totalOrdersConfirm',
            'totalOrdersCancel',
            'dailyRevenue',
            'latestOrders',
            'orderStatus',
            'totalCustomers',
            'totalStaff',
            'grossProfitToday',
            'bestSellingProducts',
            'successMessage',
        ));
    }

    private function config()
    {
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

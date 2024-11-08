@if (isset($successMessage) || isset($errorMessage))
    <script type="text/javascript">
        $(document).ready(function() {
            @if (isset($successMessage))
            toastr.success('{{ $successMessage }}', 'Thành công', {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 5000
            });
            @endif

            @if (isset($errorMessage))
            toastr.error('{{ $errorMessage }}', 'Lỗi', {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 5000
            });
            @endif
        });
    </script>
@endif
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right">Xác nhận</span>
                    <h5>ĐƠN HÀNG CHỜ</h5>
                </div>
                <div class="ibox-content">
                    <a href="{{ route('orders.index') }}"><h1 class="no-margins">{{ isset($totalOrdersConfirm) ? $totalOrdersConfirm : 0 }}</h1></a>
                    <small>Trên tổng số đơn hàng</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                <span class="label label-success pull-right">
                    Tháng {{ isset($results[0]['month']) ? $results[0]['month'] : 0 }}
                </span>
                    <h5>ĐƠN HÀNG TRONG</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        {{ isset($results[0]['total_orders']) ? $results[0]['total_orders'] : 0 }}
                    </h1>
                    <div class="stat-percent font-bold
                    {{ isset($results[0]['growth']) && $results[0]['growth'] > 0 ? 'text-success' : 'text-danger' }}">
                        {{ isset($results[0]['growth']) ? $results[0]['growth'] : '0%' }}
                        <i class="fa
                        {{ isset($results[0]['growth']) && $results[0]['growth'] > 0 ? 'fa-level-up' : 'fa-level-down' }}">
                        </i>
                    </div>

                    <small>
{{--                        @dd($results)--}}
                        @if(isset($results[0]['growth']))
                            @if($results[0]['growth'] > 0)
                                Tăng so với tháng trước
                            @elseif($results[0]['growth'] < 0)
                                Giảm so với tháng trước
                            @else
                                Không thay đổi so với tháng trước
                            @endif
                        @else
                            Không có dữ liệu
                        @endif
                    </small>
                </div>
            </div>
        </div>

{{--        <div class="col-lg-3">--}}
{{--            <div class="ibox float-e-margins">--}}
{{--                <div class="ibox-title">--}}
{{--                    <span class="label label-info pull-right">Tổng số đơn hàng</span>--}}
{{--                    <h5>ĐƠN HÀNG</h5>--}}
{{--                </div>--}}
{{--                <div class="ibox-content">--}}
{{--                    <h1 class="no-margins">{{ isset($totalOrders) ? $totalOrders : 0 }}</h1>--}}
{{--                    <div class="stat-percent font-bold text-info">--}}
{{--                        {{ isset($cancellationRate) ? $cancellationRate : '0%' }}--}}
{{--                        <i class="fa fa-level-up"></i>--}}
{{--                    </div>--}}
{{--                    <small>Số đơn hủy {{ isset($canceledOrders) ? $canceledOrders : 0 }} chiếm</small>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Tổng</span>
                    <h5>TỔNG DOANH THU</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($results[0]['total_revenue']) ? number_format($results[0]['total_revenue']) : '0.00' }}</h1>
                    <div class="stat-percent font-bold
                    {{ isset($results[0]['revenue_growth']) && $results[0]['revenue_growth'] > 0 ? 'text-navy' : 'text-danger' }}">
                        {{ isset($results[0]['revenue_growth']) ? $results[0]['revenue_growth'] : '0%' }}
                        <i class="fa
                        {{ isset($results[0]['revenue_growth']) && $results[0]['revenue_growth'] > 0 ? 'fa-level-up' : 'fa-level-down' }}">
                        </i>
                    </div>
                    <small>Tổng doanh thu</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Khách hàng</span>
                    <h5>TỔNG KHÁCH HÀNG</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($totalCustomers) ? $totalCustomers : 0 }}</h1>
                    <small>Tổng số khách hàng</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="padding-top: 5px"> BIỂU ĐỒ THỐNG KÊ DOANH THU</h5>
                    <div class="right" style="margin-left: 70%">
                        <form id="filterForm" action="{{ route('dashboard.post') }}" method="POST">
                            @csrf
                            <h5 style="padding-top: 7px; padding-right: 10px">THỜI GIAN</h5>

                            <input type="date" name="date_start" class="btn btn-xs btn-white" value="{{ old('date_start') }}">
                            <input type="date" name="end_date" class="btn btn-xs btn-white" value="{{ old('end_date') }}">

                            <select name="choose_time" id="" class="btn btn-xs btn-white">
                                <option value="year" {{ old('choose_time') == 'year' ? 'selected' : '' }}>Năm</option>
                                <option value="month" {{ old('choose_time') == 'month' ? 'selected' : '' }}>Tháng</option>
                                <option value="week" {{ old('choose_time') == 'week' ? 'selected' : '' }}>Tuần</option>
                                <option value="day" {{ old('choose_time') == 'day' ? 'selected' : '' }}>Ngày</option>
                            </select>

                            <button class="btn btn-primary">Lọc</button>
                        </form>

                        <script>
                            document.getElementById('filterForm').addEventListener('submit', function(event) {
                                let dateStart = document.querySelector('input[name="date_start"]').value;
                                let endDate = document.querySelector('input[name="end_date"]').value;

                                if (!dateStart || !endDate) {
                                    event.preventDefault(); // Ngăn không cho submit form
                                    toastr.error('Vui lòng nhập đầy đủ ngày bắt đầu và ngày kết thúc!', 'Thông báo');
                                }
                            });
                        </script>

                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-9">
                            <div>
                                <canvas id="myChart" ></canvas>
                            </div>
                            <?php
                            // Giả sử $results đã được khai báo và chứa dữ liệu của bạn
                            $chartData = array_fill(1, 12, 0); // Khởi tạo tất cả tháng với giá trị 0

                            // Kiểm tra nếu $results tồn tại và có dữ liệu
                            if (isset($results) && !empty($results)) {
                                foreach ($results as $result) {
                                    $month = (int)$result['month']; // Lấy số tháng từ ngày
                                    $doanh_thu = $result['total_revenue']; // Doanh thu từ kết quả
                                    $chartData[$month] += $doanh_thu; // Cộng dồn doanh thu cho tháng tương ứng
                                }
                            }
                            ?>

                            <script>
                                const ctx = document.getElementById('myChart');

                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5',
                                            'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10',
                                            'Tháng 11', 'Tháng 12'
                                        ],
                                        datasets: [{
                                            label: 'Doanh thu',
                                            data: [
                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                    <?= $chartData[$i] ?><?= $i < 12 ? ',' : '' ?>
                                                <?php endfor; ?>
                                            ],
                                            borderWidth: 0.2,
                                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                            borderColor: 'rgba(75, 192, 192, 1)'
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            </script>

                        </div>
                        <div class="col-lg-3">
                            <ul class="stat-list">
                                <li>
                                    @php
                                        // Tính tổng số đơn hàng từ dữ liệu mới gửi lên nếu có
                                        $totalOrders1 = isset($results_one) ? collect($results_one)->sum('so_luong_don_hang') : 0;

                                        // Kiểm tra nếu đã có tổng số đơn hàng mặc định
                                        $totalOrders = isset($totalOrders) ? $totalOrders : 0;

                                        // Quyết định hiển thị giá trị nào
                                        $displayTotalOrders = $totalOrders1 > 0 ? $totalOrders1 : $totalOrders;
                                    @endphp
                                    <h2 class="no-margins">{{ $displayTotalOrders }}</h2>
                                    <small>Tổng số đơn đặt hàng</small>
                                    <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </li>

                                <li>
                                    @php
                                        $totalCancelOrders = isset($results_one) ? collect($results_one)->sum('tong_so_don_hang_huy') : 0; // Tính tổng số đơn hàng đã hủy
                                        $canceledOrders = isset($canceledOrders) ? $canceledOrders : 0;
                                        $TotalCancelOrders = $totalCancelOrders > 0 ? $totalCancelOrders : $canceledOrders;
                                    @endphp
                                    <h2 class="no-margins">{{ $TotalCancelOrders }}</h2>
                                    <small>Tổng số đơn hàng đã hủy</small>
                                    <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    @php
                                        $totalRevenue = isset($results_one) ? collect($results_one)->sum('doanh_thu') : 0; // Tính tổng doanh thu

                                        // Kiểm tra nếu đã có tổng số doanh thu mặc định
                                        $totalRevenue_month = isset($results[0]['total_revenue']) ? number_format($results[0]['total_revenue']) : '0.00'; // Đã thêm dấu chấm phẩy

                                        // Quyết định hiển thị giá trị nào
                                        $displayTotalRevenue = $totalRevenue > 0 ? $totalRevenue : $totalRevenue_month;
                                    @endphp
                                    <h2 class="no-margins">{{ $displayTotalRevenue }}</h2>
                                    <small>Doanh thu</small>
                                    <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar"></div>
                                    </div>
                                </li>

                            </ul>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>BIỂU ĐỒ THỐNG KÊ LỢI NHUẬN</h5>
                </div>
                <div class="ibox-content">
                    <canvas id="myChart_bar"></canvas>
                    <script>
                        // Tạo các mảng để lưu trữ nhãn và dữ liệu
                        const labels = []; // Mảng nhãn cho các sản phẩm
                        const barData = []; // Dữ liệu cho biểu đồ cột
                        const lineData = []; // Dữ liệu cho biểu đồ đường

                        // Kiểm tra xem $grossProfit có tồn tại không
                        @if (isset($grossProfit) && count($grossProfit) > 0)
                        // Duyệt qua $grossProfit để lấy tên sản phẩm, lợi nhuận gộp và số lượng
                        @foreach ($grossProfit as $item)
                        labels.push('{{ $item->product_name }} - Tháng {{ $item->month }}');
                        barData.push({{ $item->gross_profit }}); // Thêm lợi nhuận gộp vào dữ liệu cho biểu đồ cột
                        lineData.push({{ $item->total_quantity }}); // Thêm số lượng vào dữ liệu cho biểu đồ đường
                        @endforeach
                        @else
                        // Nếu không có dữ liệu, thêm giá trị mặc định
                        labels.push('Không có dữ liệu');
                        barData.push(0); // Giá trị mặc định cho lợi nhuận gộp
                        lineData.push(0); // Giá trị mặc định cho số lượng bán
                        @endif

                        const ctxBar = document.getElementById('myChart_bar').getContext('2d');

                        // Hiển thị biểu đồ
                        document.getElementById('myChart_bar').style.display = 'block'; // Hiển thị biểu đồ

                        const dataBar = {
                            labels: labels,
                            datasets: [{
                                type: 'bar',
                                label: 'Lợi Nhuận Gộp',
                                data: barData,
                                borderColor: 'rgb(255, 99, 132)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                yAxisID: 'y', // Chỉ định trục y cho lợi nhuận
                            }, {
                                type: 'line',
                                label: 'Số Lượng Bán',
                                data: lineData,
                                fill: false,
                                borderColor: 'rgb(54, 162, 235)',
                                yAxisID: 'y1', // Chỉ định trục y cho số lượng
                            }]
                        };

                        const configBar = {
                            type: 'bar',
                            data: dataBar,
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        position: 'left', // Vị trí của trục y
                                        title: {
                                            display: true,
                                            text: 'Lợi Nhuận Gộp'
                                        }
                                    },
                                    y1: {
                                        beginAtZero: true,
                                        position: 'right', // Vị trí của trục y cho số lượng
                                        title: {
                                            display: true,
                                            text: 'Số Lượng Bán'
                                        },
                                        grid: {
                                            drawOnChartArea: false // Không vẽ lưới cho trục này
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            title: function(tooltipItems) {
                                                // Hiển thị thông tin về tháng trong tooltip
                                                return `Tháng: ${tooltipItems[0].label.split(' - ')[1] || 'N/A'}`; // Tách tháng hoặc N/A nếu không có
                                            },
                                            label: function(tooltipItem) {
                                                // Hiển thị thêm thông tin trong tooltip
                                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                            }
                                        }
                                    }
                                }
                            },
                        };

                        const myChartBar = new Chart(ctxBar, configBar); // Vẽ biểu đồ
                    </script>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>THỐNG KÊ TRẠNG THÁI ĐƠN HÀNG</h5>
                </div>
                <div class="ibox-content">
                    <canvas id="myChartPie"></canvas>
                    <script>
                        const dataPie = {
                            labels: [
                                <?php
                                if (count($orderStatus) > 0) {
                                    // Nếu có dữ liệu thì tạo các nhãn từ trạng thái đơn hàng
                                    foreach ($orderStatus as $status) {
                                        echo "'" . App\Models\Order::STATUS_NAMES[$status->status] . "',";
                                    }
                                } else {
                                    // Nếu không có dữ liệu, tạo nhãn mặc định
                                    echo "'No Data',";
                                }
                                ?>
                            ],
                            datasets: [{
                                label: 'Total Orders by Status',
                                data: [
                                    <?php
                                    if (count($orderStatus) > 0) {
                                        // Nếu có dữ liệu thì tạo các giá trị từ trạng thái đơn hàng
                                        foreach ($orderStatus as $status) {
                                            echo $status->total . ',';
                                        }
                                    } else {
                                        // Nếu không có dữ liệu, cung cấp giá trị mặc định
                                        echo '0,';
                                    }
                                    ?>
                                ],
                                backgroundColor: [
                                    <?php
                                    if (count($orderStatus) > 0) {
                                        // Nếu có dữ liệu, sử dụng màu sắc phù hợp cho từng trạng thái
                                        foreach ($orderStatus as $status) {
                                            switch ($status->status) {
                                                case 1: echo "'rgb(255, 205, 86)',"; break;
                                                case 2: echo "'rgba(75, 192, 192, 0.2)',"; break;
                                                case 3: echo "'rgb(201, 203, 207)',"; break;
                                                case 4: echo "'rgb(54, 162, 235)',"; break;
                                                case 5: echo "'rgb(75, 192, 192)',"; break;
                                                case 6: echo "'rgb(255, 99, 99)',"; break;
                                                default: echo "'rgb(0, 0, 0)',"; break;
                                            }
                                        }
                                    } else {
                                        // Màu mặc định nếu không có dữ liệu
                                        echo "'rgb(128, 128, 128)',";
                                    }
                                    ?>
                                ],
                                hoverOffset: 4
                            }]
                        };

                        const configPie = {
                            type: 'polarArea',
                            data: dataPie,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                const label = tooltipItem.label || '';
                                                const value = tooltipItem.raw || 0;
                                                return `${label}: ${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        const myChartPie = new Chart(
                            document.getElementById('myChartPie'),
                            configPie
                        );
                    </script>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>TOP 10 KHÁCH HÀNG THÁNG NÀY</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-hover margin bottom">
                                        <thead>
                                        <tr>
                                            <th style="width: 1%" class="text-center">STT</th>
                                            <th class="text-center">Email</th>
                                            <th >Trạng Thái</th>
                                            <th class="text-center">Thời Gian</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestUsers as $latestUser)
                                            <tr>
                                                <td class="text-center">{{ $latestUser->id }}</td>
                                                <td class="text-center">{{ $latestUser->email }}</td>
                                                <td>
                                                    <span class="label {{ $latestUser->publish == 1 ? 'label-primary' : 'label-warning' }}">
                                                        {{ $latestUser->publish == 1 ? 'Hoạt động' : 'Khóa' }}
                                                    </span>
                                                </td>

                                                <td class="text-center">{{ $latestUser->created_at }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>TOP 10 ĐƠN HÀNG MỚI THÁNG NÀY</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-hover margin bottom">
                                        <thead>
                                        <tr>
                                            <th style="width: 1%" class="text-center">STT</th>
                                            <th style="width: 150px">Thông Tin</th>
                                            <th class="text-center">Tổng Tiền</th>
                                            <th class="text-center">Trạng Thái</th>
                                            <th class="text-center">Thời Gian</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestOrders as $latestOrder)
                                            <tr>
                                                <td class="text-center">{{ $latestOrder->id }}</td>
                                                <td>
                                                    <ul class="list-unstyled mb-0">
                                                        <li><strong>Tên:</strong> {{ $latestOrder->full_name }}</li>
                                                        <li><strong>Địa chỉ:</strong> {{ $latestOrder->address }}</li>
                                                        <li><strong>Điện thoại:</strong> {{ $latestOrder->phone }}</li>
                                                    </ul>
                                                </td>
                                                <td class="text-center">{{ number_format($latestOrder->total_price, 0, ',', '.') }} VNĐ</td>
                                                <td class="text-center">
                                                    @php
                                                        // Định nghĩa các trạng thái và màu sắc tương ứng
                                                        $statuses = [
                                                            1 => ['label' => 'Chờ xác nhận', 'color' => 'label-warning'], // Waiting for confirmation
                                                            2 => ['label' => 'Đã xác nhận', 'color' => 'label-success'], // Confirmed
                                                            3 => ['label' => 'Đang chuẩn bị', 'color' => 'label-info'], // Preparing
                                                            4 => ['label' => 'Đang vận chuyển', 'color' => 'label-secondary'], // In transit
                                                            5 => ['label' => 'Đã giao hàng', 'color' => 'label-primary'], // Delivered
                                                            6 => ['label' => 'Hủy đơn hàng', 'color' => 'label-danger'] // Order cancelled
                                                        ];
                                                    @endphp
                                                    @php
                                                        // Lấy trạng thái tương ứng
                                                        $currentStatus = $statuses[$latestOrder->status] ?? ['label' => 'Không xác định', 'color' => 'label-default'];
                                                    @endphp
                                                    <span class="label {{ $currentStatus['color'] }}">{{ $currentStatus['label'] }}</span>
                                                </td>

                                                <td class="text-center">{{ $latestOrder->created_at }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

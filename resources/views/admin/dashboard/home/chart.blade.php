@if (isset($successMessage) || isset($errorMessage))
<script type="text/javascript">
    $(document).ready(function() {
        @if(isset($successMessage))
        toastr.success('{{ $successMessage }}', 'Thành công', {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
        @endif

        @if(isset($errorMessage))
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
                    <span class="label label-warning pull-right">
                        Trong kho
                    </span>
                    <h5>TỔNG SẢN PHẨM</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        {{ isset($totalProduct) ? $totalProduct : 0 }}
                    </h1>
                    <small>
                        Sản phẩm trong hệ thống
                    </small>
                </div>
            </div>

        </div>
        
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Ngày {{ isset($dailyRevenue->date) ? $dailyRevenue->date : 0 }}</span>
                    <h5>TỔNG DOANH THU</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($dailyRevenue->total_revenue) ? number_format($dailyRevenue->total_revenue) : '0.00' }}</h1>
                    <small>Tổng doanh thu</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Hoạt động</span>
                    <h5>TỔNG NHÂN SỰ</h5>
                </div>
                <div class="ibox-content">
                    <a href="{{ route('orders.index') }}">
                        <h1 class="no-margins">{{ isset($totalStaff) ? $totalStaff : 0 }}</h1>
                    </a>
                    <small>Khách hàng trên hệ thống</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Hoạt động</span>
                    <h5>TỔNG KHÁCH HÀNG</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($totalCustomers) ? $totalCustomers : 0 }}</h1>
                    <small>Khách hàng trên hệ thống</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">
                        Ngày {{ isset($dailyRevenue->date) ? $dailyRevenue->date : 0 }}
                    </span>
                    <h5>TỔNG ĐƠN HÀNG</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        {{ isset($dailyRevenue->total_orders) ? $dailyRevenue->total_orders : 0 }}
                    </h1>
                    <small>
                        Đơn hàng đã hoàn thành
                    </small>
                </div>
            </div>

        </div>

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Ngày {{ isset($dailyRevenue->date) ? $dailyRevenue->date : 0 }}</span>
                    <h5>TỔNG LỢI NHUẬN</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($grossProfitToday) ? number_format($grossProfitToday) : '0.00' }}</h1>
                    <small>Tổng doanh thu</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right">Xác nhận</span>
                    <h5>ĐƠN HÀNG CHỜ</h5>
                </div>
                <div class="ibox-content">
                    <a href="{{ route('orders.index') }}">
                        <h1 class="no-margins">{{ isset($totalOrdersConfirm) ? $totalOrdersConfirm : 0 }}</h1>
                    </a>
                    <small>Trên tổng số đơn hàng</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Đã hủy</span>
                    <h5>ĐƠN HÀNG</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($totalOrdersCancel) ? $totalOrdersCancel : 0 }}</h1>
                    <small>Trên tổng số đơn hàng</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="padding-top: 5px"> BIỂU ĐỒ THỐNG KÊ DOANH THU</h5>
                    <div class="right" style="margin-left: 62%">
                        <form id="filterForm" action="{{ route('dashboard.post') }}" method="POST">
                            @csrf
                            <h5 style="padding-top: 7px; padding-right: 10px">THỜI GIAN</h5>

                            <!-- Input date_start -->
                            <input type="date" name="date_start" class="btn btn-xs btn-white" value="{{ request('date_start', '0') }}">

                            <!-- Input end_date -->
                            <input type="date" name="end_date" class="btn btn-xs btn-white" value="{{ request('end_date', '0') }}">

                            <!-- Dropdown chọn khoảng thời gian -->
                            <select name="choose_time" id="" class="btn btn-xs btn-white">
                                <option value="year" {{ request('choose_time') == 'year' ? 'selected' : '' }}>Năm</option>
                                <option value="month" {{ request('choose_time') == 'month' ? 'selected' : '' }}>Tháng</option>
                                <option value="week" {{ request('choose_time') == 'week' ? 'selected' : '' }}>Tuần</option>
                                <option value="day" {{ request('choose_time') == 'day' ? 'selected' : '' }}>Ngày</option>
                            </select>

                            <!-- Nút lọc -->
                            <button class="btn btn-primary">Lọc</button>
                        </form>

                        <script>
                            document.getElementById('filterForm').addEventListener('submit', function(event) {
                                let dateStart = document.querySelector('input[name="date_start"]').value;
                                let endDate = document.querySelector('input[name="end_date"]').value;

                                if (!dateStart || !endDate) {
                                    event.preventDefault(); // Ngăn không cho submit form
                                    toastr.error('Vui lòng nhập đầy đủ ngày bắt đầu và ngày kết thúc!', 'Thông báo');
                                    return;
                                }

                                // Chuyển đổi chuỗi ngày thành đối tượng Date để so sánh
                                let start = new Date(dateStart);
                                let end = new Date(endDate);

                                if (end < start) {
                                    event.preventDefault(); // Ngăn không cho submit form
                                    toastr.error('Ngày kết thúc không được nhỏ hơn ngày bắt đầu!', 'Thông báo');
                                    return;
                                }
                            });
                        </script>


                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-9">
                            <div style="height: 400px; width: 100%;">
                                <canvas id="myChart"></canvas>
                            </div>

                            <?php
                            $chartData = [];
                            $labels = []; // Khai báo mảng để chứa nhãn

                            // Kiểm tra lựa chọn thời gian
                            $timeFilter = request('choose_time'); // Nhận giá trị từ dropdown

                            // Lấy dữ liệu doanh thu theo thời gian
                            foreach ($results_one as $value) {
                                $date = $value['date']; // Lấy ngày ở định dạng 'Y-W' cho tuần
                                $revenue = $value['revenue'];

                                if ($timeFilter == 'month') {
                                    // Nếu lọc theo tháng
                                    $month = date('n', strtotime($date)); // Lấy tháng từ ngày
                                    $chartData[$month] = ($chartData[$month] ?? 0) + $revenue; // Cộng dồn doanh thu theo tháng
                                    // Thêm nhãn cho tháng
                                    if (!in_array("Tháng $month", $labels)) {
                                        $labels[] = "Tháng $month";
                                    }
                                } elseif ($timeFilter == 'week') {
                                    // Nếu lọc theo tuần
                                    list($year, $week) = explode('-', $date); // Lấy năm và tuần từ chuỗi
                                    $chartData[$week] = ($chartData[$week] ?? 0) + $revenue; // Cộng dồn doanh thu theo tuần
                                    // Thêm nhãn cho tuần
                                    if (!in_array("Tuần $week", $labels)) {
                                        $labels[] = "Tuần $week";
                                    }
                                } elseif ($timeFilter == 'day') {
                                    // Nếu lọc theo ngày
                                    $day = date('j', strtotime($date)); // Lấy ngày trong tháng (1-31)
                                    $chartData[$day] = ($chartData[$day] ?? 0) + $revenue; // Cộng dồn doanh thu theo ngày
                                    // Thêm nhãn cho ngày
                                    if (!in_array("Ngày $day", $labels)) {
                                        $labels[] = "Ngày $day";
                                    }
                                } elseif ($timeFilter == 'year') {
                                    // Nếu lọc theo năm
                                    $year = date('Y', strtotime($date)); // Lấy năm từ ngày
                                    $chartData[$year] = ($chartData[$year] ?? 0) + $revenue; // Cộng dồn doanh thu theo năm
                                    // Thêm nhãn cho năm
                                    if (!in_array("$year", $labels)) {
                                        $labels[] = "$year";
                                    }
                                }
                            }

                            // Xử lý để đảm bảo dữ liệu cho tất cả các khoảng thời gian
                            foreach ($labels as $label) {
                                $num = (int) filter_var($label, FILTER_SANITIZE_NUMBER_INT); // Lấy số từ nhãn
                                if (!isset($chartData[$num])) {
                                    $chartData[$num] = 0; // Gán 0 cho các khoảng không có dữ liệu
                                }
                            }
                            ?>

                            <script>
                                const ctx = document.getElementById('myChart');

                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: <?= json_encode($labels) ?>, // Sử dụng mảng nhãn
                                        datasets: [{
                                            label: 'Doanh thu',
                                            data: [
                                                <?php
                                                foreach ($labels as $label) {
                                                    $num = (int) filter_var($label, FILTER_SANITIZE_NUMBER_INT); // Lấy số từ nhãn
                                                    echo isset($chartData[$num]) ? $chartData[$num] : 0;
                                                    echo ($label !== end($labels)) ? ',' : ''; // Thêm dấu phẩy nếu không phải nhãn cuối cùng
                                                }
                                                ?>
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
                                    $totalOrders = isset($results_one) ? collect($results_one)->sum('total_orders') : 0;
                                    @endphp
                                    <h2 class="no-margins">{{ $totalOrders }}</h2>
                                    <small>Tổng số đơn hàng</small>
                                    <div class="stat-percent"> <i class="fa fa-bolt text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    @php
                                    $totalRevenue = isset($results_one) ? collect($results_one)->sum('quantity_sold') : 0; // Tính tổng số lượng bán ra
                                    @endphp
                                    <h2 class="no-margins">{{ $totalRevenue }}</h2>
                                    <small>Số lượng bán ra</small>
                                    <div class="stat-percent"> <i class="fa fa-bolt text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    @php
                                    $totalCancelOrders = isset($results_one) ? collect($results_one)->sum('total_canceled_orders') : 0; // Tính tổng số đơn hàng đã hủy
                                    @endphp
                                    <h2 class="no-margins">{{ $totalCancelOrders }}</h2>
                                    <small>Tổng số đơn hàng đã hủy</small>
                                    <div class="stat-percent"> <i class="fa fa-bolt text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    @php
                                    $totalRevenue = isset($results_one) ? collect($results_one)->sum('revenue') : 0; // Tính tổng doanh thu
                                    @endphp
                                    <h2 class="no-margins">{{ $totalRevenue }}</h2>
                                    <small>Doanh thu</small>
                                    <div class="stat-percent"> <i class="fa fa-bolt text-navy"></i></div>
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
                    <h5>BIỂU ĐỒ THỐNG KÊ LỢI NHUẬN VÀ SỐ LƯỢNG BÁN</h5>
                </div>
                <div class="ibox-content">
                    <canvas id="myChart_bar"></canvas>
                    <script>
                        // Tạo các mảng dữ liệu
                        const labels = []; // Mảng nhãn (Tên sản phẩm + Tháng)
                        const productNames = []; // Tên sản phẩm
                        const productColor = []; // Tên sản phẩm
                        const productSize = []; // Tên sản phẩm
                        const profitData = []; // Lợi nhuận gộp
                        const quantityData = []; // Số lượng bán

                        @if(isset($grossProfit) && count($grossProfit) > 0)
                            @foreach($grossProfit as $item)
                                labels.push(" {{ $item->date }}");
                                productNames.push("{{ $item->product_name }}");
                                productColor.push("{{ $item->color_name }}");
                                productSize.push("{{ $item->size_name }}");
                                profitData.push({{ $item->gross_profit }});
                                quantityData.push({{ $item->total_quantity }});
                            @endforeach
                        @else
                            labels.push('Không có dữ liệu');
                            productNames.push(null);
                            productColor.push(null);
                            productSize.push(null);
                            profitData.push(null);
                            quantityData.push(null);
                        @endif

                        // Cấu hình dữ liệu và biểu đồ
                        const dataMixed = {
                            labels: labels,
                            datasets: [
                                {
                                    type: 'line', // Biểu đồ đường cho lợi nhuận gộp
                                    label: 'Lợi Nhuận Gộp (VND)',
                                    data: profitData,
                                    fill: false,
                                    borderColor: 'rgba(255, 99, 132, 1)', // Màu đỏ cho lợi nhuận
                                    tension: 0.4,
                                    borderWidth: 2,
                                    pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 5
                                },
                                {
                                    type: 'line', // Biểu đồ đường cho số lượng bán
                                    label: 'Số Lượng Bán',
                                    data: quantityData,
                                    fill: false,
                                    borderColor: 'rgba(54, 162, 235, 1)', // Màu xanh lam cho số lượng bán
                                    tension: 0.4,
                                    borderWidth: 2,
                                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 5
                                },
                            ],
                        };

                        const configMixed = {
                            type: 'line',
                            data: dataMixed,
                            options: {
                                responsive: true,
                                interaction: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                scales: {
                                    y: {
                                        type: 'linear',
                                        position: 'left',
                                        title: {
                                            display: true,
                                            text: 'Lợi Nhuận Gộp (VND)',
                                        },
                                        beginAtZero: true,
                                    },
                                    yQuantity: {
                                        type: 'linear',
                                        position: 'right',
                                        title: {
                                            display: true,
                                            text: 'Số Lượng Bán',
                                        },
                                        beginAtZero: true,
                                        grid: {
                                            drawOnChartArea: false, // Không hiển thị lưới trục số lượng
                                        },
                                    },
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            title: function(tooltipItems) {
                                                return tooltipItems[0].label; // Hiển thị nhãn
                                            },
                                            label: function(tooltipItem) {
                                                const value = tooltipItem.raw;
                                                const label = tooltipItem.dataset.label;
                                                const month = tooltipItem.label; // Tháng
                                                const product = productNames[tooltipItem.dataIndex]; // Tên sản phẩm
                                                const color = productColor[tooltipItem.dataIndex]; // Màu sắc
                                                const size = productSize[tooltipItem.dataIndex]; // Kích thước

                                                // Hiển thị thông tin chi tiết trong tooltip
                                                return `${label}: ${value} - ${product} (${color}, ${size})`;
                                            }
                                        }
                                    },
                                    legend: {
                                        position: 'top',
                                    }
                                }
                            },
                        };

                        // Vẽ biểu đồ
                        const ctxMixed = document.getElementById('myChart_bar').getContext('2d');
                        new Chart(ctxMixed, configMixed);
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
                            <h5>TOP 10 SẢN PHẨM BÁN CHẠY TRONG THÁNG</h5>
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
                                                <th class="text-center">Tên sản phẩm</th>
                                                <th>Màu sác</th>
                                                <th>Kích thước</th>
                                                <th class="text-center">Ngày mua</th>
                                                <th class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bestSellingProducts as $index => $bestSellingProduct)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $bestSellingProduct->product_name }}</td>
                                                <td class="text-center">{{ $bestSellingProduct->color_name }}</td>
                                                <td class="text-center">{{ $bestSellingProduct->size_name }}</td>
                                                <td class="text-center">{{ $bestSellingProduct->sale_date }}</td>
                                                <td class="text-center">

                                                </td>
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
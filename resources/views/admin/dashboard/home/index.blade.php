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

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Tổng số đơn hàng</span>
                    <h5>ĐƠN HÀNG</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($totalOrders) ? $totalOrders : 0 }}</h1>
                    <div class="stat-percent font-bold text-info">
                        {{ isset($cancellationRate) ? $cancellationRate : '0%' }}
                        <i class="fa fa-level-up"></i>
                    </div>
                    <small>Số đơn hủy {{ isset($canceledOrders) ? $canceledOrders : 0 }} chiếm</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Tổng</span>
                    <h5>TỔNG DOANH THU</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ isset($results[0]['total_revenue']) ? number_format($results[0]['total_revenue'], 2) : '0.00' }}</h1>
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
                    <h5 style="padding-top: 5px"> BIỂU ĐỒ DOANH SỐ</h5>
                    <div class="right" style="margin-left: 62%">
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
                                <canvas id="myChart"></canvas>
                            </div>
                            <?php
                            // Giả sử $results đã được khai báo và chứa dữ liệu của bạn
                            $chartData = array_fill(1, 12, 0); // Khởi tạo tất cả tháng với giá trị 0

                            // Giả sử $results chứa dữ liệu doanh thu cho từng tháng
                            foreach ($results as $result) {
                                $month = (int)$results[0]['month']; // Lấy số tháng từ ngày
                                $doanh_thu = $result['total_revenue']; // Doanh thu từ kết quả
                                $chartData[$month] += $doanh_thu; // Cộng dồn doanh thu cho tháng tương ứng
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
                                        $totalRevenue_month = isset($results[0]['total_revenue']) ? number_format($results[0]['total_revenue'], 2) : '0.00'; // Đã thêm dấu chấm phẩy

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
                                            <th class="text-center">Trạng Thái</th>
                                            <th class="text-center">Thời Gian</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($latestUsers as $latestUser)
                                            <tr>
                                                <td class="text-center">{{ $latestUser->id }}</td>
                                                <td class="text-center">{{ $latestUser->email }}</td>
                                                <td>
                                                    <span class="label {{ $latestUser->status == 1 ? 'label-primary' : 'label-warning' }}">
                                                        {{ $latestUser->status == 1 ? 'Hoạt động' : 'Khóa' }}
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

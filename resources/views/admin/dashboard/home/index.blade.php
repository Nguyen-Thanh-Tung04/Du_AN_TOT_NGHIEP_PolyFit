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
                    <div class="right">
                        <form action="{{ route('dashboard.post') }}" method="POST">
                            @csrf
                            <h5 style="padding-top: 7px; padding-right: 10px">THỜI GIAN </h5>
                            <input type="date" name="date_start" class="btn btn-xs btn-white">
                            <input type="date" name="end_date" class="btn btn-xs btn-white">
                            <select name="choose_time" id="" class="btn btn-xs btn-white">
                                <option value="year">Năm</option>
                                <option value="month">Tháng</option>
                                <option value="week">Tuần</option>
                                <option value="date">Ngày</option>
                            </select>
                            <input type="submit" value="Lọc" name="search" class="btn btn-primary">
                        </form>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-9">
                            <div id="chart-container" style="position: relative;">
{{--                                <div id="chart-title" style="text-align: center; font-weight: bold; font-size: 20px; position: absolute; top: 10px; width: 100%; color: #333;">--}}
{{--                                    Doanh thu--}}
{{--                                </div>--}}
{{--                                <div id="flot-dashboard-chart" style="width: 600px; height: 400px;"></div>--}}
                            </div>

                            <div class="flot-chart">
                                <div id="chart-title" style="text-align: center; font-weight: 500; font-size: 20px; position: absolute; top: 10px; width: 100%; color: #333;">
                                    Doanh thu
                                </div>
                                <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <ul class="stat-list">
                                <li>
                                    <h2 class="no-margins">2,346</h2>
                                    <small>Tổng số đơn đặt hàng</small>
                                    <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    <h2 class="no-margins ">4,422</h2>
                                    <small>Tổng số đơn hàng đã hủy</small>
                                    <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    <h2 class="no-margins ">9,180</h2>
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
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>TIN NHẮN</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-envelope-o"></i> New messages</h3>
                    <small><i class="fa fa-tim"></i> You have 22 new messages and 16 waiting in draft folder.</small>
                </div>
                <div class="ibox-content">
                    <div class="feed-activity-list">

                        <div class="feed-element">
                            <div>
                                <small class="pull-right text-navy">1m ago</small>
                                <strong>Monica Smith</strong>
                                <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                                <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">2m ago</small>
                                <strong>Jogn Angel</strong>
                                <div>There are many variations of passages of Lorem Ipsum available</div>
                                <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Jesica Ocean</strong>
                                <div>Contrary to popular belief, Lorem Ipsum</div>
                                <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Monica Jackson</strong>
                                <div>The generated Lorem Ipsum is therefore </div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>


                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Anna Legend</strong>
                                <div>All the Lorem Ipsum generators on the Internet tend to repeat </div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Damian Nowak</strong>
                                <div>The standard chunk of Lorem Ipsum used </div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Gary Smith</strong>
                                <div>200 Latin words, combined with a handful</div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">

            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>TOP SẢN PHẨM BÁN CHẠY</h5>
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
                            <table class="table table-hover no-margins">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><small>Pending...</small></td>
                                    <td><i class="fa fa-clock-o"></i> 11:20pm</td>
                                    <td>Samantha</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 24% </td>
                                </tr>
                                <tr>
                                    <td><span class="label label-warning">Canceled</span> </td>
                                    <td><i class="fa fa-clock-o"></i> 10:40am</td>
                                    <td>Monica</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 66% </td>
                                </tr>
                                <tr>
                                    <td><small>Pending...</small> </td>
                                    <td><i class="fa fa-clock-o"></i> 01:30pm</td>
                                    <td>John</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 54% </td>
                                </tr>
                                <tr>
                                    <td><small>Pending...</small> </td>
                                    <td><i class="fa fa-clock-o"></i> 02:20pm</td>
                                    <td>Agnes</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 12% </td>
                                </tr>
                                <tr>
                                    <td><small>Pending...</small> </td>
                                    <td><i class="fa fa-clock-o"></i> 09:40pm</td>
                                    <td>Janet</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 22% </td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>TRẠNG THÁI ĐƠN HÀNG</h5>
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
                            <canvas id="myPieChart" width="400" height="400"></canvas>

                            <script>
                                const ctx = document.getElementById('myPieChart').getContext('2d');
                                const myPieChart = new Chart(ctx, {
                                    type: 'pie', // Loại biểu đồ: 'pie'
                                    data: {
                                        labels: ['Nhóm A', 'Nhóm B', 'Nhóm C', 'Nhóm D'], // Nhãn cho các phần
                                        datasets: [{
                                            label: 'Giá Trị', // Nhãn cho dataset
                                            data: [10, 20, 30, 40], // Dữ liệu cho biểu đồ
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)',
                                                'rgba(255, 206, 86, 0.6)',
                                                'rgba(75, 192, 192, 0.6)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true, // Đảm bảo biểu đồ đáp ứng
                                        plugins: {
                                            legend: {
                                                position: 'top', // Vị trí của legend
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(tooltipItem) {
                                                        return tooltipItem.label + ': ' + tooltipItem.raw; // Hiển thị nhãn và giá trị
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
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
                                            <th style="padding-left: 45px">Thông Tin</th>
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

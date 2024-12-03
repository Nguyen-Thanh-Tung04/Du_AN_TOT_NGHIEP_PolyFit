
@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['edit']['title']])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="ibox">
    <div class="ibox-content">
         <!-- Hiển thị tất cả các phiên bản từ ReviewHistory -->
        <h5>Lịch sử cập nhật</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nội dung</th>
                    <th>Số sao</th>
                    <th>Người dùng</th>
                    <th>Loại</th>
                    <th>Hành động</th>
                    <th>Ngày cập nhật</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviewsHistory as $history)
                @if($history->type == 'review')
                    <tr>
                        <td>{{ $history->content }}</td>
                        <td>{{ $history->score ?? '--' }}</td>
                        <td>{{ $history->user->name }}</td>
                        <td>{{ $history->type == 'review' ? 'Đánh giá' : 'Phản hồi' }}</td>
                        <td>{{ ucfirst($history->action) }}</td>
                        <td>{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                 @endif

                @endforeach
            </tbody>
        </table>

        <!-- Hiển thị riêng các phản hồi của đánh giá -->
        <h5>Danh sách phản hồi</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nội dung phản hồi</th>
                    <th>Người trả lời</th>
                    <th>Loại</th>
                    <th>Hành động</th>
                    <th>Ngày cập nhật</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviewsHistory as $history)
                    @if($history->type == 'reply')
                        <tr>
                            <td>{{ $history->content }}</td>
                            <td>{{ $history->user->name }}</td>
                            <td>{{ $history->type == 'review' ? 'Đánh giá' : 'Phản hồi' }}</td>
                            <td>{{ ucfirst($history->action) }}</td>
                            <td>{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>


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

<div class="container">
    @if($reviewsHistory->isNotEmpty())
    @php
        $firstReview = $reviewsHistory->firstWhere('type', 'review');
    @endphp

    @if($firstReview)
        <div class="col-lg-6" style="margin-top: 30px">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-8 mb-15">
                            <div class="form-row">
                                <label class="control-label text-left">Tên người dùng : </label>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ $firstReview->user->name ?? '' }}"
                                    class="form-control"
                                    placeholder=""
                                    autocomplete="off"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-15">
                            <div class="form-row">
                                <label class="control-label text-left">Số sao đánh giá : </label>
                                <input
                                    type="text"
                                    name="score"
                                    value="{{ $firstReview->score ?? '--' }}"
                                    class="form-control"
                                    placeholder=""
                                    autocomplete="off"
                                    disabled
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-15">
                            <div class="form-row">
                                <label class="control-label text-left">Nội dung đánh giá : </label>
                                <textarea
                                    name="content"
                                    class="form-control"
                                    disabled
                                >{{ $firstReview->content ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-lg-6 mb-15">
                        <div class="form-row">
                            <label class="control-label text-left">Ảnh trải nghiệm :
                            </label>
                        </div>
                    </div>
                    <td class="text-center">
                        <img src="{{ asset(Storage::url($firstReview->review->image)) }}" alt="" style="max-height: 130px; width: 100px;">
                    </td>
                </div>
                </div>
            </div>
        </div>
    @endif
@endif

   
    <div class="col-lg-6" style="margin-top: 30px">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12 mb-15">
                        <div class="form-row">
                            <h3 class="col-lg-12 text-center m-auto font-weight-bold text-uppercase mt-3">
                                Lịch sử đánh giá
                            </h3>
                            
                            
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
                                        <tr>
                                            <!-- Hiển thị nội dung đánh giá hoặc phản hồi -->
                                            <td>{{ $history->content }}</td>
                            
                                            <!-- Hiển thị số sao chỉ cho đánh giá -->
                                            <td>{{ $history->type == 'review' ? $history->score ?? '--' : '--' }}</td>
                            
                                            <!-- Hiển thị người dùng -->
                                            <td>{{ $history->user->name }}</td>
                            
                                            <!-- Loại (Đánh giá hoặc Phản hồi) -->
                                            <td>{{ $history->type == 'review' ? 'Đánh giá' : 'Phản hồi' }}</td>
                            
                                            <!-- Hành động (sửa, xóa...) -->
                                            <td>{{ ucfirst($history->action) }}</td>
                            
                                            <!-- Ngày cập nhật -->
                                            <td>{{ $history->created_at->format('m-d-Y H:i:s') }}</td>
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
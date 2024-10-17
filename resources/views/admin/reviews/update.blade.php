
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
                                value="{{ old('name', ($reviews->name) ?? '') }}"
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
                            <label class="control-label text-left">Số sao đánh giá : 
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', ($reviews->score) ?? '') }}"
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
                            <label class="control-label text-left">Nội dung đánh giá :
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', ($reviews->content) ?? '') }}"
                                class="form-control"
                                placeholder=""
                                autocomplete="off"
                                disabled
                            >
                        </div>
                    </div>
                    
                </div>
                @if($reviews->image)
                <div class="row">
                    <div class="col-lg-6 mb-15">
                        <div class="form-row">
                            <label class="control-label text-left">Ảnh trải nghiệm :
                            </label>
                        </div>
                    </div>
                    <td class="text-center">
                        <img width="100px" src="{{ asset(Storage::url($reviews->image)) }}" alt="">
                    </td>
                </div>
                @endif
                
            </div>
        </div>
    </div>
    <form action="{{ route('reviews.reply', $reviews->id) }}" method="post" class="box" style="margin-top: 30px" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12 mb-15">
                            <div class="form-row">
                                <label class="control-label text-left">Người đã trả lời đánh giá : <span style="color:brown">{{isset($reply)?$reply->user->name:"Chưa ai trả lời"}}</span></label>                                <!-- Kiểm tra nếu có reply, nếu có thì hiển thị giá trị của reply -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-15">
                            <div class="form-row">
                                <label class="control-label text-left">Trả lời đánh giá
                                    <span class="text-danger">(*)</span>
                                </label>
                                <!-- Kiểm tra nếu có reply, nếu có thì hiển thị giá trị của reply -->
                                <textarea name="content" class="form-control" cols="30" rows="10">{{ isset($reply) ? old('content', $reply->content) : old('content') }}</textarea>
                            </div>
                        </div>
                    </div>
    
                    <!-- Hiển thị nút "Cập nhật" nếu đã có reply, hoặc "Gửi" nếu chưa có -->
                    @if(isset($reply))
                        <button class="btn btn-warning">Cập nhật</button>
                    @else
                        <button class="btn btn-primary">Gửi</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
        
</div>


   
{{-- {{ $category->links('pagination::bootstrap-5') }} --}}

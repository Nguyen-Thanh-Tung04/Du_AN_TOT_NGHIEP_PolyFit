
@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['delete']['title']])

<form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="box">
    @csrf
    @method('DELETE')   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Bạn đang muốn xóa danh mục có tên là: <span class="text-danger">{{ $review->name }}</span></p>
                        <p>Lưu ý: Không thể khôi phục danh mục sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này.<span class="text-danger">(*) </span>là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tên người dùng
                                        </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($review->name) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Nội dung :
                                        </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($review->content) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Số sao :
                                        </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($review->score) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Hình ảnh trải nghiệm :
                                        </label>
                                        <td class="text-center">
                                            <img width="100px" src="{{ asset(Storage::url($review->image)) }}" alt="">
                                        </td>
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb-15">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không !')" name="send" value="send">Xóa dữ liệu</button>
        </div>
    </div>
</form>


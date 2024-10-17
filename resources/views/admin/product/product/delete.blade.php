@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['delete']['title']])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('product.destroy', $product->id) }}" method="POST" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-heading">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Bạn đang muốn xóa thành viên có email là: {{ $product->email }}</p>
                        <p>Lưu ý: Không thể khôi phục thành viên sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này.<span class="text-danger">(*) </span>là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Mã sản phẩm
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="code"
                                        value="{{ old('code', ($product->code) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Tên sản phẩm
                                        <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($product->name) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb-15">
            <button type="submit" class="btn btn-danger" name="send" value="send">Xóa dữ liệu</button>
        </div>
    </div>
</form>
@php
    $url = route('product.destroyVariant', $product->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    @if (isset($product->variants) && $product->variants->isNotEmpty())
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Màu Sắc</th>
                                                <th class="text-center">Kích cỡ</th>
                                                <th class="text-center">Giá nhập kho</th>
                                                <th class="text-center">Giá niêm yết</th>
                                                <th class="text-center">Giá sale</th>
                                                <th class="text-center">Số lượng</th>
                                                <th class="text-center">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="variant-tbody">
                                            @foreach ($product->variants as $variant)
                                                <tr class="variant-row">
                                                    <td class="text-center">
                                                        <select disabled name="color[]" class="form-control">
                                                            <option value="0">Màu Sắc</option>
                                                            @foreach ($getColorAttr as $item)
                                                                <option {{ old('color[]', $item->id == $variant->color_id ? 'selected' : '') }}
                                                                    value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-center" style="padding: 20px 0">
                                                        <select disabled name="size[]" class="form-control">
                                                            <option value="0">Kích cỡ</option>
                                                            @foreach ($getSizeAttr as $item)
                                                                <option {{ old('size[]', $item->id == $variant->size_id ? 'selected' : '') }}
                                                                    value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <input readonly type="text" name="purchase_price[]" value="{{ old('purchase_price[]', $variant->purchase_price) }}" placeholder="Giá nhập kho" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input readonly type="text" name="listed_price[]" value="{{ old('listed_price[]', $variant->listed_price) }}" placeholder="Giá niêm yết" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input readonly type="text" name="sale_price[]" value="{{ old('sale_price[]', $variant->sale_price) }}" placeholder="Giá sale" class="form-control">
                                                    </td>
                                                    <td class="text-center">
                                                        <input readonly type="text" name="quantity[]" value="{{ old('quantity[]', $variant->quantity) }}" placeholder="Số lượng" class="form-control">
                                                    </td>
                                                    <input type="hidden" name="variant_id[]" value="{{ $variant->id ?? '' }}">
                                                    <td class="text-center">
                                                        <button type="submit" class="btn btn-danger remove-variant-detail" data-variant-id="{{ $variant->id }}"><i class="fa fa-trash "></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <input type="hidden" name="delete_variant_id" id="delete_variant_id" value="">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
</form>

@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['detail']['title']])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    $url = route('product.destroyVariant', $product->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row" style="margin-bottom:53px">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <table class="table table-sm table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" style="width:100px;">Ảnh</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th class="text-center">Tình Trạng</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if (isset($product) && is_object($product))
                                    @php
                                        $gallery = json_decode($product->gallery, true);
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            <span><img class="image img-cover" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt=""></span>
                                        </td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td class="text-center js-switch-{{ $product->id }}">
                                            <input readonly type="checkbox" value="{{ $product->status }}" 
                                            class="js-switch status "
                                            {{ ($product->status == 1) ? 'checked' : '' }}/>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        @if (isset($product->variants) && $product->variants->isNotEmpty())
                                        <thead>
                                            <tr>
                                                <th class="text-center">Màu Sắc</th>
                                                <th class="text-center">Kích cỡ</th>
                                                <th class="text-center">Giá nhập kho</th>
                                                <th class="text-center">Giá niêm yết</th>
                                                <th class="text-center">Giá sale</th>
                                                <th class="text-center">Số lượng</th>
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
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="form-row">
                                    <div class="uk-flex uk-middle uk-flex-space-between">
                                        <label for="" class="control-label text-left">Mô tả sản phẩm</label>
                                    </div>
                                    <textarea readonly
                                        type="text"
                                        id="ckContent"
                                        class="form-control ck-editor"
                                        placeholder=""
                                        autocomplete="off"
                                        data-height="500">
                                        {!! $product->description !!}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>



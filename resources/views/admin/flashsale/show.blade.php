@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['detail']['title']])

<div action="{{ route('flashsale.update', $flashSale->id) }}" method="POST" id="flashSaleForm">
    @csrf
    @method('PUT')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label for="date">Ngày</label>
                                    <input class="form-control" type="date" id="date" value="{{ $flashSale->date }}" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label for="time_slot">Khung giờ</label>
                                    @php
                                    $times = explode('-', $flashSale->time_slot);
                                    $formattedSlot = sprintf('%02d:00 - %02d:00', $times[0], $times[1]);
                                    @endphp
                                    <input class="form-control" type="text" id="time_slot" value="{{ $formattedSlot }}" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label for="status">Trạng thái</label>
                                    <input class="form-control" type="text" id="status" value="{{ $flashSale->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="uk-flex uk-flex-space-between">
                                    <h3>Danh sách sản phẩm tham gia</h3>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="row" id="productList">

                                    @foreach($flashSale->products as $product)
                                    @if($product)
                                    <div class="custom-col-12 custom-mb-3">
                                        <div class="custom-card custom-border-gray">
                                            <div class="custom-card-header custom-bg-light-gray custom-text-dark">
                                                <div class="uk-flex uk-flex-space-between uk-flex-middle" style="width: 100%;">
                                                    <div>
                                                        @php
                                                        $gallery = json_decode($product->gallery);
                                                        @endphp
                                                        <img src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt="" class="custom-img-thumbnail" style="width: 50px; height: 50px;">
                                                        <span>{{ $product->name }}</span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="custom-card-body custom-bg-white">
                                                <div class="custom-table-header">
                                                    <div class="custom-col-1 custom-text-left">Màu</div>
                                                    <div class="custom-col-1 custom-text-center">Size</div>
                                                    <div class="custom-col-2 custom-text-center">Giá gốc</div>
                                                    <div class="custom-col-2 custom-text-center">Giá giảm</div>
                                                    <div class="custom-col-2 custom-text-center">Khuyến mãi</div>
                                                    <div class="custom-col-1 custom-text-center">Kho hàng</div>
                                                    <div class="custom-col-2 custom-text-center">Số lượng khuyến mãi</div>
                                                    <div class="custom-col-1 custom-text-right">Trạng thái</div>
                                                </div>

                                                @foreach($product->variants as $variant)
                                                <div class="custom-row custom-mb-2">
                                                    <div class="custom-col-1 custom-text-left">{{ $variant['color'] }}</div>
                                                    <div class="custom-col-1 custom-text-center">{{ $variant['size']  }}</div>
                                                    <div class="custom-col-2 custom-text-center original-price">{{ $variant['listed_price'] }}</div>
                                                    <div class="custom-col-2 custom-text-center"><input disabled type="number" value="{{ $variant['flash_price'] }}" class="form-control discount-price" min="0" max="{{ $variant['listed_price'] }}"></div>
                                                    <div class="custom-col-2 custom-text-center input-group">
                                                        <input type="number" class="form-control discount-percent" aria-describedby="percent-addon" value="{{ $variant['discount_percentage'] }}" disabled>
                                                        <span class="input-group-addon" id="percent-addon">% Giảm</span>
                                                    </div>
                                                    <div class="custom-col-1 custom-text-center">{{ $variant['quantity_max'] }}</div>
                                                    <div class="custom-col-2 custom-text-center"><input disabled type="number" class="form-control discount-quantity" value="{{ $variant['quantity'] }}" min="0" max="{{ $variant['quantity'] }}" placeholder="Số lượng"></div>
                                                    <div class="custom-col-1 custom-text-right">
                                                        <input disabled type="checkbox" class="js-switch status-variant" value="{{ $variant['status'] }}" {{ $variant['status'] == 1 ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb-5">
            <a href="{{ route('flashsale.index') }}" class="btn btn-primary ">Quay lại</a>

        </div>
    </div>

</div>
<div id="productPopup" class="popup">
    <div class="popup-dialog">
        <div class="popup-content">
            <!-- Header -->
            <div class="popup-header">
                <h3>Chọn sản phẩm</h3>
                <span id="closePopup" class="close-btn">×</span>
            </div>

            <!-- Body -->
            <div class="popup-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                                </th>
                                <th class="text-center" style="width:100px;">Ảnh</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($products) && is_object($products))
                            @foreach($products as $product)
                            @php
                            $gallery = json_decode($product->gallery, true);
                            $isSelected = in_array($product->id, $selectedProductIds);
                            @endphp
                            <tr class="{{ $isSelected ? 'active-bg' : '' }}">
                                <td>
                                    <input type="checkbox" class="checkBoxItem" value="{{ $product->id }}" {{ $isSelected ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <span><img class="image img-cover" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt=""></span>
                                </td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Footer -->
            <div class="popup-footer">
                <button type="button" id="cancelSelection" class="btn btn-primary">Hủy</button>
                <button type="button" id="confirmSelection" class="btn btn-danger">Xác nhận</button>
            </div>
        </div>
    </div>

</div>
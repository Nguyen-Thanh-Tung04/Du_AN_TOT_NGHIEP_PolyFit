@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['edit']['title']])

<form action="{{ route('flashsale.update', $flashSale->id) }}" method="POST" id="flashSaleForm">
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
                                    @php
                                    $today = now()->format('Y-m-d');
                                    @endphp
                                    <input class="form-control" type="date" name="date" id="date" value="{{ $flashSale->date }}" min="{{ $today }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label for="time_slot">Khung giờ</label>
                                    <select name="time_slot" id="time_slot" class="form-control" required>
                                        @foreach($availableSlots as $slot)
                                        @php
                                        $times = explode('-', $slot);
                                        $formattedSlot = sprintf('%02d:00 - %02d:00', $times[0], $times[1]);
                                        @endphp
                                        <option value="{{ $slot }}" {{ $flashSale->time_slot == $slot ? 'selected' : '' }}>{{ $formattedSlot }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" {{ $flashSale->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ $flashSale->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
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
                                    <button id="openPopup" class="btn btn-danger">
                                        <i class="fa fa-plus mr-5"></i>
                                        Thêm sản phẩm
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="row" id="productList">

                                    @foreach($flashSale->products as $product)
                                    @if($product)
                                    <div class="custom-col-12 custom-mb-3">
                                        <input type="hidden" name="products[{{ $product->id }}]" value="{{ $product->id }}">
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
                                                    <div>
                                                        <button type="button" class="custom-btn-danger custom-btn-sm remove-product-flash" data-id="{{ $product->id }}"><i class="fa fa-trash"></i></button>
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
                                                    <div class="custom-col-2 custom-text-center original-price" data-price="{{ $variant['listed_price'] }}">{{ $variant['listed_price'] }}</div>
                                                    <input type="hidden" name="products[{{ $product->id }}][{{ $variant['variant_id'] }}][listed_price]" value="{{ $variant['listed_price'] }}">
                                                    <div class="custom-col-2 custom-text-center"><input type="number" name="products[{{ $product->id }}][{{ $variant['variant_id'] }}][flash_price]" value="{{ $variant['flash_price'] }}" class="form-control discount-price" min="0" max="{{ $variant['listed_price'] }}"></div>
                                                    <div class="custom-col-2 custom-text-center input-group">
                                                        <input type="number" class="form-control discount-percent" aria-describedby="percent-addon" value="{{ $variant['discount_percentage'] }}" disabled>
                                                        <input type="hidden" name="products[{{ $product->id }}][{{ $variant['variant_id'] }}][discount_percentage]" value="{{ $variant['discount_percentage'] }}" class="form-control discount-percent">
                                                        <span class="input-group-addon" id="percent-addon">% Giảm</span>
                                                    </div>
                                                    <div class="custom-col-1 custom-text-center">{{ $variant['quantity_max'] }}</div>
                                                    <div class="custom-col-2 custom-text-center"><input type="number" name="products[{{ $product->id }}][{{ $variant['variant_id'] }}][quantity]" class="form-control discount-quantity" value="{{ $variant['quantity'] }}" min="0" max="{{ $variant['quantity'] }}" placeholder="Số lượng"></div>
                                                    <div class="custom-col-1 custom-text-right">
                                                        <input type="hidden" name="products[{{ $product->id }}][{{ $variant['variant_id'] }}][status]" class="status-value" value="{{ $variant['status'] }}">
                                                        <input type="checkbox" class="js-switch status-variant" value="{{ $variant['status'] }}" {{ $variant['status'] == 1 ? 'checked' : '' }}>
                                                    </div>
                                                    <input type="hidden" name="products[{{ $product->id }}][{{ $variant['variant_id'] }}][product_id]" value="{{ $product->id }}">
                                                    <input type="hidden" name="products[{{ $product->id }}][{{ $variant['variant_id'] }}][variant_id]" value="{{ $variant['variant_id'] }}">
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
            <button type="submit" class="btn btn-primary">Cập Nhật Flash Sale</button>
        </div>
    </div>

</form>
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
                    <table class="table table-sm table-striped table-bordered" id="product-flash">
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
                                    <span><img class="image img-cover datatable-image" src="{{ (!empty($gallery)) ? $gallery[0] : '' }}" alt=""></span>
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
<script>
    $(document).ready(function() {
        var checkedRows = {};

        var table = $('#product-flash').DataTable({
            language: {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "Xem _MENU_ mục",
                "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix": "",
                "sSearch": "Tìm:",
                "sUrl": "",
            }
        });

        $('#product-flash').on('change', 'input[type="checkbox"]', function() {
            var rowId = $(this).val();
            checkedRows[rowId] = $(this).is(':checked');
        });

        $('#openPopup').on('click', function(e) {
            e.preventDefault();
            $('#productPopup').show();
        });

        $('#closePopup, #cancelSelection').on('click', function() {
            $('#productPopup').fadeOut();
        });

        $('.checkBoxItem:checked').each(function() {
            var rowId = $(this).val();
            checkedRows[rowId] = $(this).is(':checked');
        });

        $(document).on('click', '.remove-product-flash', function() {
            let productId = $(this).data('id');
            let checkBox = $(`.checkBoxItem[value="${productId}"]`);
            checkBox.prop('checked', false).trigger('click');
            $(this).closest('.custom-col-12').remove();
        });


        $(document).on('change', '.status-variant', function() {
            let status = this.checked ? 1 : 0;
            $(this).closest('.custom-row').find('.status-value').val(status);
        });

        // Calculate discount percent
        $(document).on('input', '.discount-price', function() {
            let originalPrice = parseFloat($(this).closest('.custom-row').find('.original-price').first().text());
            let discountPrice = parseFloat($(this).val());
            if (discountPrice < 0) {
                discountPrice = 0;
                $(this).val(0);
            } else if (discountPrice > originalPrice) {
                discountPrice = originalPrice;
                $(this).val(originalPrice);
            }
            let discountPercent = ((originalPrice - discountPrice) / originalPrice) * 100;
            $(this).closest('.custom-row').find('.discount-percent').val(Math.round(discountPercent));
        });

        // Validate discount quantity
        $(document).on('input', '.discount-quantity', function() {
            let maxQuantity = parseInt($(this).attr('max'));
            let discountQuantity = parseInt($(this).val());
            if (discountQuantity < 0) {
                discountQuantity = 0;
                $(this).val(0);
            } else if (discountQuantity > maxQuantity) {
                discountQuantity = maxQuantity;
                $(this).val(maxQuantity);
            }
        });

        $('#confirmSelection').on('click', function() {
            let selectedProductIds = [];
            $.each(checkedRows, function(rowId, isChecked) {
                if (isChecked) {
                    selectedProductIds.push(rowId);
                }
            });

            if (selectedProductIds.length > 0) {
                $.ajax({
                    url: '{{ route("flashsale.getSelectedProducts") }}',
                    method: 'GET',
                    data: {
                        ids: selectedProductIds.join(',')
                    },
                    success: function(response) {
                        let productList = $('#productList');
                        response.products.forEach(function(product) {
                            if ($(`input[name="products[${product.id}]"]`).length === 0) {
                                let productCard = `
                                <div class="custom-col-12 custom-mb-3">
                                    <input type="hidden" name="products[${product.id}]" value="${product.id}">
                                    <div class="custom-card custom-border-gray">
                                        <div class="custom-card-header custom-bg-light-gray custom-text-dark">
                                              <div class="uk-flex uk-flex-space-between uk-flex-middle" style="width: 100%;">
                                                <div>
                                                    <img src="${product.image}" alt="" class="custom-img-thumbnail" style="width: 50px; height: 50px;">
                                                    <span>${product.name}</span>
                                                </div>
                                                <div>
                                                    <button type="button" class="custom-btn-danger custom-btn-sm remove-product-flash" data-id="${product.id}"><i class="fa fa-trash"></i></button>
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
                                            ${product.variants.map(variant => `
                                            <div class="custom-row custom-mb-2">
                                                <div class="custom-col-1 custom-text-left">${variant.color}</div>
                                                <div class="custom-col-1 custom-text-center">${variant.size}</div>
                                                <div class="custom-col-2 custom-text-center original-price" data-price="${variant.price}">${variant.price}</div>
                                                <input type="hidden" name="products[${product.id}][${variant.id}][listed_price]" value="${variant.price}">
                                                <div class="custom-col-2 custom-text-center"><input type="number" name="products[${product.id}][${variant.id}][flash_price]" value="${variant.price}" class="form-control discount-price" min="0" max="${variant.price}"></div>
                                                <div class="custom-col-2 custom-text-center input-group">
                                                    <input type="number" name="products[${product.id}][${variant.id}][discount_percentage]" value="0" class="form-control discount-percent" aria-describedby="percent-addon">
                                                    <span class="input-group-addon" id="percent-addon">% Giảm</span>
                                                </div>
                                                <div class="custom-col-1 custom-text-center">${variant.quantity}</div>
                                                <div class="custom-col-2 custom-text-center"><input type="number" name="products[${product.id}][${variant.id}][quantity]" class="form-control discount-quantity" value="${variant.quantity}" min="0" max="${variant.quantity}" placeholder="Số lượng"></div>
                                                <div class="custom-col-1 custom-text-right">
                                                 <input type="hidden"  name="products[${product.id}][${variant.id}][status]" class="status-value" value="1">
                                                    <input type="checkbox" class="new-switch status-variant" checked value="1">
                                                </div>
                                                <input type="hidden" name="products[${product.id}][${variant.id}][variant_id]" value="${variant.id}">
                                            </div>`).join('')}
                                        </div>
                                    </div>
                                </div>`;
                                productList.append(productCard);

                                $('.new-switch').each(function() {
                                    new Switchery(this, {
                                        color: '#1AB394',
                                        size: 'small'
                                    });
                                });
                            }
                        });

                        $('#productPopup').fadeOut();
                    }
                });
            } else {
                toastr.warning('Vui lòng chọn ít nhất một sản phẩm.');
            }
        });

        $('#date').on('change', function() {
            let selectedDate = $(this).val();
            let today = new Date().toISOString().split('T')[0];
            let currentTime = new Date().getHours();
            let timeSlots = [{
                    value: '0-9',
                    text: '00:00 - 09:00'
                },
                {
                    value: '9-12',
                    text: '09:00 - 12:00'
                },
                {
                    value: '12-15',
                    text: '12:00 - 15:00'
                },
                {
                    value: '15-18',
                    text: '15:00 - 18:00'
                },
                {
                    value: '18-21',
                    text: '18:00 - 21:00'
                },
                {
                    value: '21-24',
                    text: '21:00 - 24:00'
                }
            ];

            $.ajax({
                url: '{{ route("flashsale.getOccupiedTimeSlots") }}',
                method: 'GET',
                data: {
                    date: selectedDate
                },
                success: function(response) {
                    let occupiedSlots = response.occupiedSlots;
                    let availableSlots = timeSlots.filter(slot => {
                        if (selectedDate === today) {
                            let [startHour] = slot.value.split('-').map(Number);
                            if (startHour <= currentTime) {
                                return false;
                            }
                        }
                        return !occupiedSlots.includes(slot.value);
                    });

                    let timeSlotSelect = $('#time_slot');
                    timeSlotSelect.empty();
                    availableSlots.forEach(slot => {
                        timeSlotSelect.append(`<option value="${slot.value}">${slot.text}</option>`);
                    });
                }
            });
        });

        $('#flashSaleForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);

            let formData = new FormData(form[0]);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        window.location.href = "{{ route('flashsale.index') }}";
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
    });
</script>
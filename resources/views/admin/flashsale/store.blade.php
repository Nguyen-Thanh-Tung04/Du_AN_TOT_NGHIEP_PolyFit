@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{route('flashsale.store') }}" method="post" class="box" enctype="multipart/form-data">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Ngày
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    @php
                                    $today = now()->format('Y-m-d');
                                    @endphp
                                    <input class="form-control" type="date" name="date" id="date" min="{{ $today }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Khung giờ
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <select name="time_slot" id="time_slot" class="form-control" required>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-15">
                                <div class="form-row">
                                    <label class="control-label text-left">Trạng thái
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Không hoạt động</option>
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
                                    <a id="openPopup" class="btn btn-danger">
                                        <i class="fa fa-plus mr-5"></i>
                                        Thêm sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 mb-15">
                                <div class="row" id="productList">
                                    <!-- Các sản phẩm được chọn sẽ hiển thị ở đây -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb-5">
            <button id="flashSaleForm" class="btn btn-primary" name="send" value="send">Tạo Flash Sale</button>
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
                @include('admin.flashsale.component.product')
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
                "oPaginate": {
                    "sFirst": "Đầu",
                    "sPrevious": "Trước",
                    "sNext": "Tiếp",
                    "sLast": "Cuối"
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [0, 1]
            }]
        });

        $('#product-flash').on('change', 'input[type="checkbox"]', function() {
            var rowId = $(this).val();
            checkedRows[rowId] = $(this).is(':checked');
        });

        table.on('draw', function() {
            $.each(checkedRows, function(rowId, isChecked) {
                $('input[type="checkbox"][value="' + rowId + '"]').prop('checked', isChecked);
            });
        });
        $('#openPopup').on('click', function(e) {
            e.preventDefault();
            $('#productPopup').show();
        });

        $('#closePopup, #cancelSelection').on('click', function() {
            $('#productPopup').fadeOut();
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
                        productList.empty();
                        response.products.forEach(function(product) {
                            let productCard = `
                            <div class="custom-col-12 custom-mb-3">
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
                                                <input type="number"  value="0" class="form-control discount-percent" aria-describedby="percent-addon" disabled>
                                                <input type="hidden" name="products[${product.id}][${variant.id}][discount_percentage]" value="0" class="form-control discount-percent" >
                                                <span class="input-group-addon" id="percent-addon">% Giảm</span>
                                            </div>
                                            <div class="custom-col-1 custom-text-center">${variant.quantity}</div>
                                            <div class="custom-col-2 custom-text-center"><input type="number" name="products[${product.id}][${variant.id}][quantity]" class="form-control discount-quantity" value="${variant.quantity}" min="0" max="${variant.quantity}" placeholder="Số lượng"></div>
                                            <div class="custom-col-1 custom-text-right"><input type="checkbox" name="products[${product.id}][${variant.id}][status]" class="js-switch" value="1" checked></div>
                                            <input type="hidden" name="products[${product.id}][${variant.id}][product_id]" value="${product.id}">
                                            <input type="hidden" name="products[${product.id}][${variant.id}][variant_id]" value="${variant.id}">
                                        </div>`).join('')}
                                    </div>
                                </div>
                            </div>`;
                            productList.append(productCard);
                        });

                        // Initialize Switchery
                        $('.js-switch').each(function() {
                            new Switchery(this, {
                                color: '#1AB394',
                                size: 'small'
                            });
                        });

                        $('.js-switch').on('change', function() {
                            if (this.checked) {
                                this.value = 1;
                            } else {
                                this.value = 0;
                            }
                        });

                        // Remove product and uncheck checkbox
                        $('.remove-product-flash').on('click', function() {
                            let productId = $(this).data('id');
                            let checkBox = $(`.checkBoxItem[value="${productId}"]`);
                            console.log(checkBox);
                            checkBox.trigger('click'); // Trigger click event
                            $(this).closest('.custom-col-12').remove();
                        });

                        // Calculate discount percent
                        $('.discount-price').on('input', function() {
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

                        $('.discount-quantity').on('input', function() {
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
                            let [, endHour] = slot.value.split('-').map(Number);
                            if (endHour <= currentTime) {
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

        $('#flashSaleForm').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            form.find('input[type="checkbox"]').each(function() {
                if (!this.checked) {
                    $(this).prop('checked', true).val(0);
                } else {
                    $(this).val(1);
                }
            });
            let formData = new FormData(form[0]);
            $.ajax({
                url: "{{ route('flashsale.store') }}",
                method: "POST",
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
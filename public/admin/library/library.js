(function ($) {
    "use strict";
    var HT = {};
    var _token = $('meta[name="csrf-token"]').attr('content');

    HT.switchery = () => {
        $('.js-switch').each(function () {
            var switchery = new Switchery(this, { color: 'rgb(249, 58, 11)', size: 'small' });
        })
    }

    HT.select2 = () => {
        if ($('.setupSelect2').length) {
            $('.setupSelect2').select2();
        }

    }

    HT.sortui = () => {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    }

    HT.cloneVariant = () => {
        $(document).on('click', '#addVariant', function (e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của nút

            let variantRows = $('.variant-tbody tr'); // Lấy tất cả các hàng trong tbody

            let newRow;

            if (variantRows.length === 0) {
                // Nếu không có hàng nào, tạo hàng mới từ đầu
                newRow = $('<tr class="variant-row">' +
                    '<td class="text-center">' +
                    '<select name="color[]" class="form-control">' +
                    '<option value="0">Màu Sắc</option>' +
                    '</select>' +
                    '</td>' +
                    '<td class="text-center" style="padding: 20px 0">' +
                    '<select name="size[]" class="form-control">' +
                    '<option value="0">Kích cỡ</option>' +
                    '</select>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<input type="text" name="purchase_price[]" placeholder="Giá nhập kho" class="form-control">' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<input type="text" name="listed_price[]" placeholder="Giá niêm yết" class="form-control">' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<input type="text" name="sale_price[]" placeholder="Giá sale" class="form-control">' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<input type="text" name="quantity[]" placeholder="Số lượng" class="form-control">' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<a href="" class="btn btn-danger remove-variant"><i class="fa fa-trash"></i></a>' +
                    '</td>' +
                    '</tr>');
            } else {
                // Nếu đã có hàng, clone hàng đầu tiên trong tbody
                newRow = variantRows.first().clone();

                // Xóa giá trị trong các trường của hàng mới
                newRow.find('input').val('');
                newRow.find('select').prop('selectedIndex', 0); // Đặt lại lựa chọn cho dropdown
            }

            // Thêm hàng mới vào tbody
            $('.variant-tbody').append(newRow);

            // Đổ dữ liệu vào select sau khi thêm hàng mới
            populateSelectOptions();
        });

        // Hàm để đổ dữ liệu vào select
        function populateSelectOptions() {
            var colorSelect = $('.variant-row:last').find('select[name="color[]"]');
            var sizeSelect = $('.variant-row:last').find('select[name="size[]"]');

            // Đổ dữ liệu cho color
            colorSelect.empty().append('<option value="0">Màu Sắc</option>');
            colors.forEach(function (color) {
                colorSelect.append('<option value="' + color.id + '">' + color.name + '</option>');
            });

            // Đổ dữ liệu cho size
            sizeSelect.empty().append('<option value="0">Kích cỡ</option>');
            sizes.forEach(function (size) {
                sizeSelect.append('<option value="' + size.id + '">' + size.name + '</option>');
            });
        }
    }


    HT.colorAttrDuplicate = () => {
        $(document).on('change', 'select[name="color[]"], select[name="size[]"]', function () {
            var isDuplicate = false;

            // Lặp qua tất cả các hàng biến thể
            $('.variant-row').each(function (index, row) {
                var currentColor = $(row).find('select[name="color[]"]').val();
                var currentSize = $(row).find('select[name="size[]"]').val();

                // Kiểm tra nếu cả màu và kích cỡ đều đã được chọn
                if (currentColor !== '0' && currentSize !== '0') {
                    // So sánh cặp màu và kích cỡ này với các hàng khác
                    $('.variant-row').not(row).each(function (index2, otherRow) {
                        var otherColor = $(otherRow).find('select[name="color[]"]').val();
                        var otherSize = $(otherRow).find('select[name="size[]"]').val();

                        // Nếu màu và kích cỡ của một hàng khác trùng với hàng hiện tại
                        if (currentColor === otherColor && currentSize === otherSize) {
                            isDuplicate = true;
                            return false; // Thoát vòng lặp khi tìm thấy trùng lặp
                        }
                    });
                }
            });

            if (isDuplicate) {
                toastr.success('Biến thể đã tồn tại!')
                $(this).val('0'); // Đặt lại giá trị về mặc định
            }
        });
    }

    HT.removeVariant = () => {
        $(document).on('click', '.remove-variant', function (e) {
            if ($('.variant-row').length > 1) {
                if ($('.variant-row').length > 1) {
                    var _this = $(this);
                    var variantId = _this.data('variant-id');

                    _this.closest('.variant-row').remove();

                    var arrVariantIdDel = $('#delete_variant_id').val();
                    arrVariantIdDel += variantId + ',';
                    console.log(arrVariantIdDel);
                    $('#delete_variant_id').val(arrVariantIdDel);
                }
            }
            e.preventDefault();
        })
    }

    HT.removeProduct = () => {
        $(document).on('click', '.remove-product', function (e) {
            e.preventDefault();

            swal({
                title: "Bạn có chắc chắn?",
                text: "Bạn sẽ không thể khôi phục lại mục này!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Xóa!",
                cancelButtonText: "Hủy",
                closeOnConfirm: true // Đóng SweetAlert sau khi người dùng xác nhận
            }, function (isConfirm) {
                if (isConfirm) {
                    $('#submitDelProduct').submit();
                }
            });
        });
    };

    HT.removeVariantDetail = () => {
        $(document).on('click', '.remove-variant-detail', function (e) {
            e.preventDefault();  // Ngăn chặn hành động mặc định khi bấm nút "Xóa"

            var _this = $(this); // Lấy đối tượng nút bấm
            var variantId = _this.data('variant-id'); // Lấy ID của biến thể từ thuộc tính data-variant-id

            // Sử dụng SweetAlert để hiển thị hộp thoại xác nhận
            swal({
                title: "Bạn có chắc chắn?",
                text: "Bạn sẽ không thể khôi phục lại mục này!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Xóa!",
                cancelButtonText: "Hủy",
                closeOnConfirm: true // Đóng SweetAlert sau khi người dùng xác nhận
            }, function (isConfirm) {
                if (isConfirm) {
                    var arrVariantIdDel = $('#delete_variant_id').val(); // Lấy giá trị hiện tại của input ẩn
                    arrVariantIdDel += variantId + ','; // Thêm variant ID vào danh sách
                    $('#delete_variant_id').val(arrVariantIdDel); // Cập nhật lại giá trị của input ẩn

                    $('#submitDelVariant').submit();
                }
            });
        });
    };

    HT.changeStatus = () => {
        $(document).on('change', '.status', function (e) {
            let _this = $(this);
            let currentValue = _this.val(); // Giá trị hiện tại trước khi thay đổi
            let option = {
                'value': currentValue,
                'modelId': _this.attr('data-modelId'),
                'model': _this.attr('data-model'),
                'field': _this.attr('data-field'),
                '_token': _token,
            }
    
            $.ajax({
                url: 'ajax/dashboard/changeStatus',
                type: 'POST',
                data: option,
                dataType: 'json',
                success: function (res) {
                    // Giá trị sau khi thay đổi (nếu là 1 thì đổi thành 2, và ngược lại)
                    let inputValue = (currentValue == 1) ? 2 : 1;
                    
                    if (res.flag == true) {
                        // Cập nhật giá trị mới cho input
                        _this.val(inputValue);
    
                        // Tùy thuộc vào trạng thái mới, hiển thị thông báo tương ứng
                        if (inputValue == 1) {
                            Swal.fire({
                                title: "Bật trạng thái thành công!",
                                text: "Trạng thái đã được bật.",
                                icon: "success",
                                confirmButtonColor: "rgb(249, 58, 11)",
                            });
                        } else {
                            Swal.fire({
                                title: "Đã tắt trạng thái thành công!",
                                text: "Trạng thái đã được tắt và tắt tất cả những dữ liệu trong nó.",
                                icon: "success",
                                confirmButtonColor: "rgb(249, 58, 11)",
                            });
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
                }
            });
    
            e.preventDefault();
        });
    }
    

    // Sự kiện click cho nút xóa
    $('.btn-delete').on('click', function (e) {
        e.preventDefault(); // Ngăn không cho form submit ngay lập tức

        var _this = $(this); // Lưu lại tham chiếu của nút để dùng sau
        var form = _this.closest('form'); // Tìm form chứa nút xóa

        // Hiển thị SweetAlert2 để xác nhận
        Swal.fire({
            title: "Bạn có chắc không?",
            text: "Bạn có chắc chắn muốn xóa?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đúng, hãy xóa nó!",
            cancelButtonText: "Hủy bỏ",
        }).then((result) => {
            if (result.isConfirmed) {
                // Người dùng xác nhận, tiến hành submit form để xóa
                form.submit();
            } else {
                // Nếu người dùng hủy, không làm gì cả
                Swal.fire({
                    title: "Đã hủy",
                    text: "Không có thay đổi nào được thực hiện",
                    icon: "info",
                    confirmButtonColor: "#3085d6",
                });
            }
        });
    });


    HT.checkAll = () => {
    
        if ($('#checkAll').length) {
            $(document).on('click', '#checkAll', function () {
                let isChecked = $(this).prop('checked');
                $('.checkBoxItem').prop('checked', isChecked);
                $('.checkBoxItem').each(function () {
                    let _this = $(this)
                    HT.changeBackground(_this);
                })
            })
        }
    }

    HT.checkBoxItem = () => {
        if ($('.checkBoxItem').length) {
            $(document).on('click', '.checkBoxItem', function () {
                let _this = $(this)
                HT.changeBackground(_this);
                HT.allChecked();
            })
        }
    }

    HT.changeBackground = (object) => {
        let isChecked = object.prop('checked');
        if (isChecked) {
            object.closest('tr').addClass('active-bg');
        } else {
            object.closest('tr').removeClass('active-bg');
        }
    }

    HT.allChecked = () => {
        let allChecked = $('.checkBoxItem:checked').length === $('.checkBoxItem').length;
        $('#checkAll').prop('checked', allChecked);
    }

    HT.changeStatusAll = () => {
        if ($('.changeStatusAll').length) {
            $(document).on('click', '.changeStatusAll', function (e) {
                let _this = $(this);
                let id = [];
                $('.checkBoxItem').each(function () {
                    let checkBox = $(this);
                    if (checkBox.prop('checked')) {
                        id.push(checkBox.val());
                    }
                });

                let option = {
                    'value': _this.attr('data-value'),
                    'model': _this.attr('data-model'),
                    'field': _this.attr('data-field'),
                    'id': id,
                    '_token': _token,
                }


                $.ajax({
                    url: 'ajax/dashboard/changeStatusAll',
                    type: 'POST',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.flag == true) {
                            let cssActive1 = 'background-color: rgb(249, 58, 11); border-color: rgb(249, 58, 11); box-shadow: rgb(249, 58, 11) 0px 0px 0px 11px inset; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s;';
                            let cssActive2 = 'left: 13px; background-color: rgb(255, 255, 255); transition: background-color 0.4s, left 0.2s;';
                            let cssUnactive1 = 'box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s, box-shadow 0.4s;';
                            let cssUnactive2 = 'left: 0px; transition: background-color 0.4s, left 0.2s;';

                            for (let i = 0; i < id.length; i++) {
                                if (option.value == 1) {
                                    $('.js-switch-' + id[i]).find('span.switchery')
                                        .attr('style', cssActive1).find('small').attr('style', cssActive2)
                                } else if (option.value == 2) {
                                    $('.js-switch-' + id[i]).find('span.switchery')
                                        .attr('style', cssUnactive1).find('small').attr('style', cssUnactive2)
                                }
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Lỗi: ' + textStatus + ' ' + errorThrown);
                    }
                });

                e.preventDefault();
            })

        }
    }

    // HT.getVariantId = () => {

    // }

    $(document).ready(function () {
        HT.switchery();
        HT.select2();
        HT.changeStatus();
        HT.checkAll();
        HT.checkBoxItem();
        HT.changeStatusAll();
        HT.sortui();
        HT.cloneVariant();
        HT.removeVariant();
        HT.removeVariantDetail();
        HT.removeProduct();
        HT.colorAttrDuplicate();
    });

})(jQuery);

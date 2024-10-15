@extends('client.layouts.master')
@section('content')
<div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Lịch sử mua hàng</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="index.html">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Lịch sử</li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->

<!-- User history section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
           
            <div class="ec-shop-rightside">
                <div class="ec-vendor-dashboard-card">
                    <div class="ec-vendor-card-header">
                        <h5>Lịch sử mua hàng</h5>
                        <div class="ec-header-btn">
                            <a class="btn btn-lg btn-primary" href="{{ url('/shop') }}">Mua ngay</a>
                        </div>
                    </div>
                    <div class="ec-vendor-card-body">
                        <div class="ec-vendor-card-table">
                            <table class="table ec-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã Đơn hàng</th>
                                        <th scope="col">Khách hàng</th>
                                        <th scope="col">Ngày đặt</th>
                                        <th scope="col">Tổng tiền</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                                                <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                                                <td style="font-weight: bold; ">{{ $order->status_name }}</td>
                                                <td>
                                                    <a href="{{ route('order.history.show', $order->id) }}" class="btn btn-primary">Xem</a>
                                                    <!-- Viết đánh giá Button -->
                                                    <!-- Viết đánh giá Button -->
                                                    <button type="button" class="btn btn-primary open-review-modal" 
                                                        data-order-id="{{ $order->id }}" 
                                                        data-products="{{ json_encode($order->orderItems->map(function($item) {
                                                            return [
                                                                'id' => $item->variant->product->id,
                                                                'name' => $item->variant->product->name,
                                                                'image' => $item->image,
                                                                'color' => $item->color,
                                                                'size' => $item->size,
                                                            ];
                                                        })) }}">
                                                        Viết đánh giá
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="reviewModalLabel"></h3>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                            
                                                        <div class="modal-body">
                                                            <!-- Danh sách sản phẩm trong đơn hàng -->
                                                            <div id="products-list"></div>
                                            
                                                            <div id="review-list">
                                                                <!-- Các phần tiếp theo -->
                                                            </div>
                                                                                                                         
                                                        </div>
                                            
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                                            <button type="button" class="btn btn-primary" id="submit-review">Gửi đánh giá</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
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
 
</section>
<!-- End User history section -->
@endsection

@section('scripts')
<script>
   $(document).ready(function () {
    // Đối tượng chứa mô tả tương ứng với từng ngôi sao
    var starDescriptions = {
        1: "Không thích",
        2: "Tạm được",
        3: "Bình thường",
        4: "Hài lòng",
        5: "Rất hài lòng"
    };

    // Khi người dùng chọn sao
    $('.rate input[type="radio"]').on('change', function () {
        // Lấy giá trị của sao đã chọn
        var starValue = $(this).val();

        // Cập nhật nội dung mô tả dựa trên giá trị sao
        $('.rate-text').text(starDescriptions[starValue]);

        // Hiển thị lại phần mô tả nếu nó đang bị ẩn
        if ($('.rate-text').hasClass('uk-hidden')) {
            $('.rate-text').removeClass('uk-hidden');
        }
    });


    // khi bấm đánh giá
    $(document).on('click', '.open-review-modal', function () {
        // Lấy order_idtừ button
        var orderId = $(this).data('order-id');
        var products = $(this).data('products');

        // Đổ dữ liệu vào modal
        $('#order_id').val(orderId);

        // Xóa danh sách sản phẩm cũ
        $('#products-list').empty();
        $('#review-list').empty();


        // Đổ sản phẩm vào danh sách
        products.forEach(function(product) {
            $('#products-list').append(`
                <div class="row mb-4 align-items-center">
                    <div class="col-md-3 col-12 text-center">
                        <img class="img-fluid rounded" src="${product.image}" alt="${product.name}" style="max-width: 60px;">
                    </div>
                    <div class="col-md-3 col-12">
                        <h5 class="mb-0">${product.name}</h5>
                    </div>
                    <div class="col-md-3 col-12">
                        <div>Màu: <span class="fw-bold">${product.color}</span></div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div>Kích cỡ: <span class="fw-bold">${product.size}</span></div>
                    </div>
                </div>
            `);
        });
        // Đổ form
        $('#review-list').append(`
                <!-- Form để đánh giá cả đơn hàng -->
                <div id="review-form-{{ $order->id }}">
                    <input type="hidden" name="order_id" value="${orderId}">

                    <!-- Rating Section -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-auto">
                               <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5" />
                                    <label for="star5" title="Rất hài lòng">5 stars</label>
                                    
                                    <input type="radio" id="star4" name="rate" value="4" />
                                    <label for="star4" title="Hài lòng">4 stars</label>
                                    
                                    <input type="radio" id="star3" name="rate" value="3" />
                                    <label for="star3" title="Bình thường">3 stars</label>
                                    
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label for="star2" title="Tạm được">2 stars</label>
                                    
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label for="star1" title="Không thích">1 star</label>
                                </div>
                                <div class="rate-text text-center uk-hidden">Rất hài lòng</div>
                            </div>
                        </div>
                    <!-- Textarea cho đánh giá -->
                    <div class="mb-4">
                        <textarea class="form-control" id="review_text" name="review_text" rows="4" placeholder="Mời bạn chia sẻ thêm cảm nhận ..."></textarea>
                    </div>              

                    <!-- Upload hình ảnh -->
                    <div class="mb-3 text-center">
                        <label for="file-upload" class="form-label">Hình ảnh trải nghiệm sản phẩm (nếu có)</label>
                        <div class="container-xl">
                            <div class="box-input-1"></div>
                            <label for="review_image" class="custom-file-2">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </label>
                            <span id="filesel_2">Choose a file...</span>
                            <input type="file" id="review_image" class="uk-hidden" name="review_image" accept="image/*">
                            <div id="image-preview-container" class="mt-3"></div>
                        </div>
                    </div>
                </div>                                                             
            `);

        // Hiển thị modal
        $('#reviewModalLabel').text('Viết đánh giá cho đơn hàng ' + orderId);
        $('#reviewModal').modal('show');
        
    });

    $('#submit-review').on('click', function (e) {
        e.preventDefault();

        // Create a new FormData object
        var formData = new FormData();
        
        // Add data from input fields to formData
        formData.append('review_text', $('#review_text').val());
        formData.append('rate', $('input[name="rate"]:checked').val());
        formData.append('id_order', $('input[name="order_id"]').val()); // Corrected from 'order_id' to 'id_order'

        var reviewImage = $('#review_image').prop('files')[0]; // Lấy file ảnh đầu tiên

        if (reviewImage) {
            formData.append('review_image', reviewImage); // Thêm file ảnh vào formData, không chỉ tên file
        }
        // var files = $('#review_image').prop('files');
        // if (files.length > 0) {
        //     var fileName = files[0].name; // Lấy tên file
        //     formData.append('review_image', fileName); // Chỉ lưu tên file vào formData
        // }


        // Add CSRF token if Laravel is using CSRF protection
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        // Debug formData
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Send AJAX request
        $.ajax({
            url: '/submit-review',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Thông báo',
                        text: 'Đánh giá thành công!',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 6000,
                        showCloseButton: true
                    });
                } else {
                    alert(response.message || 'Có lỗi xảy ra.');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    // Display error messages for each field
                    if (errors.review_text) {
                        $('#review_text').after('<div class="error-message text-danger fw-bold">' + errors.review_text[0] + '</div>');
                    }
                    if (errors.rate) {
                        $('input[name="rate"]').closest('.rate-group').after('<div class="error-message text-danger">' + errors.rate[0] + '</div>');
                    }
                    if (errors.review_image) {
                        $('#review_image').after('<div class="error-message text-danger fw-bold">' + errors.review_image[0] + '</div>');
                    }
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            }
        });
    });         


    $(document).on('change', '#review_image', function (event) {
        console.log('File input changed'); // Debugging line

        // Clear previous images
        $('#image-preview-container').empty();

        var file = event.target.files[0];
        console.log(file); // Check if a file has been selected

        if (file) {
            var reader = new FileReader();

            reader.onload = function (e) {
                console.log("File loaded:", e.target.result);

                var imgElement = $('<img>', {
                    src: e.target.result,
                    class: 'img-thumbnail',
                    style: 'height: 90px; width: 90px; margin-right: 5px;'
                });
                $('#image-preview-container').append(imgElement);
            };

            reader.readAsDataURL(file);
            $('#filesel_2').text('1 file selected');
        } else {
            $('#filesel_2').text('No file selected');
        }
    });




});
</script>
@endsection
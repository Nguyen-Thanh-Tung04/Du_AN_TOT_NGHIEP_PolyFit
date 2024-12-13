@extends('client.layouts.master')

@section('content')
<div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title">Lịch sử mua hàng</h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li class="ec-breadcrumb-item active">Lịch sử</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="ec-vendor-uploads ec-user-account section-space-p">
    <div class="container">
        <div class="row">
            <div class="ec-shop-rightside">
                <div class="ec-vendor-dashboard-card">
                    <div class="ec-vendor-card-header">
                        <h5>Lịch sử mua hàng</h5>
                        <div class="ec-header-btn">
                            <a class="btn btn-lg btn-primary" href="{{ url('/shop') }}">Mua ngay</a>
                        </div>
                    </div>
                    <div class="ec-vendor-card-body">
                        <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($activeTab)) active @endif" id="pending-orders-tab" data-toggle="tab" href="#pending-orders" role="tab">
                                    Chờ xác nhận @if($pendingCount > 0) <span class="text-danger">({{ $pendingCount }})</span> @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="confirmed-orders-tab" data-toggle="tab" href="#confirmed-orders" role="tab">
                                    Đã xác nhận @if($confirmedCount > 0) <span class="text-danger">({{ $confirmedCount }})</span> @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="preparing-orders-tab" data-toggle="tab" href="#preparing-orders" role="tab">
                                    Đang chuẩn bị @if($preparingCount > 0) <span class="text-danger">({{ $preparingCount }})</span> @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="shipping-orders-tab" data-toggle="tab" href="#shipping-orders" role="tab">
                                    Đang vận chuyển @if($shippingCount > 0) <span class="text-danger">({{ $shippingCount }})</span> @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="delivered-orders-tab" data-toggle="tab" href="#delivered-orders" role="tab">
                                    Đã giao hàng @if($deliveredCount > 0) <span class="text-danger">({{ $deliveredCount }})</span> @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="cancelled-orders-tab" data-toggle="tab" href="#cancelled-orders" role="tab">
                                    Đã hủy @if($cancelledCount > 0) <span class="text-danger">({{ $cancelledCount }})</span> @endif
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="orderTabContent">
                            <div class="tab-pane fade @if(empty($activeTab)) show active @endif" id="pending-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $pendingOrders])
                            </div>
                            <div class="tab-pane fade" id="confirmed-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $confirmedOrders])
                            </div>
                            <div class="tab-pane fade" id="preparing-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $preparingOrders])
                            </div>
                            <div class="tab-pane fade" id="shipping-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $shippingOrders])
                            </div>
                            <div class="tab-pane fade" id="delivered-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $deliveredOrders])
                            </div>
                            <div class="tab-pane fade" id="cancelled-orders" role="tabpanel">
                                @include('client.page.orders_table', ['orders' => $cancelledOrders])
                            </div>
                        </div>
                        
                        
                           
                        <div class="ec-vendor-card-table">
                            <table class="table ec-table">
                                <tbody>
                                    @foreach($orders as $order)
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
                                            <!-- Modal Xem đánh giá -->
                                            <div class="modal fade" id="viewReviewModal" tabindex="-1" aria-labelledby="viewReviewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="viewReviewModalLabel">Xem đánh giá</h3>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <!-- Phần hiển thị danh sách sản phẩm -->
                                                            <h5>Danh sách sản phẩm đã mua</h5>
                                                            <div id="pr-list"></div>
                                                        </div>

                                                        <div class="modal-body">
                                                            <!-- Phần hiển thị danh sách đánh giá -->
                                                            <h5>Đánh giá của bạn</h5>
                                                            <div id="view-review-list"></div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
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
                <div id="review-form-${orderId}">
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
        $('#reviewModalLabel').text('Viết đánh giá cho đơn hàng ');
        $('#reviewModal').modal('show');
        
    });

    $(document).on('change', '.rate input[type="radio"]', function () {
        var starValue = $(this).val();

        // Cập nhật nội dung mô tả dựa trên giá trị sao
        $('.rate-text').text(starDescriptions[starValue]);

        // Hiển thị lại phần mô tả nếu nó đang bị ẩn
        if ($('.rate-text').hasClass('uk-hidden')) {
            $('.rate-text').removeClass('uk-hidden');
        }
    });
   
    // Khi bấm nút 'Xem đánh giá'
    $(document).on('click', '.open-view-review-modal', function() {
        const orderId = $(this).data('order-id');
        const products = $(this).data('products');
        console.log(products);
        // Xóa danh sách sản phẩm cũ
        $('#pr-list').empty();
        // Đổ sản phẩm vào danh sách
         products.forEach(function(product) {
            $('#pr-list').append(`
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
        // Gọi AJAX để lấy danh sách đánh giá
        $.ajax({
                url: `/reviews/${orderId}`, // Đường dẫn API để lấy đánh giá
                method: 'GET',
                success: function(response) {
                    let reviewsHtml = '';
                    
                    // Check if there are reviews
                    if (response.reviews && response.reviews.length > 0) {
                        const review = response.reviews[0]; // Get the first review only
                        
                        reviewsHtml = `
                            <div class="ec-t-review-item d-flex">
                <div class="ec-t-review-avtar">
                    ${review.user.image ? `<img src="/storage/${review.user.image}" class="rounded-circle" alt="" style="width: 70px; height: 70px; object-fit: cover;" />` 
                    : '<img src="{{ asset('userfiles\thumb\Images\avata_null.jpg') }}" width="70px" class="rounded-circle" alt="" />'}
                </div>
                <div class="mx-5 ec-t-review-content">
                    <div class="ec-t-review-top">
                        <div class="ec-t-review-name">${review.user.name}</div>
                        <div class="ec-t-review-rating">
                            ${Array.from({length: 5}, (v, i) => `
                                <i class="ecicon ${i < review.score ? 'eci-star text-warning' : 'eci-star-o'}"></i>
                            `).join('')}
                        </div>
                    </div>
                    <div class="ec-t-review-bottom">
                        <p>${review.content}</p>
                    </div>
                    ${review.image ? `<img src="/storage/${review.image}" alt="Review Image" width="100">` : ''}
                    <div class="ec-t-review-bottom">
                        <p>${new Date(review.created_at).toLocaleDateString()}</p>
                    </div>
                </div>
            </div>
                        `;
                    } else {
                        reviewsHtml = `<p>Chưa có đánh giá nào cho đơn hàng này.</p>`;
                    }
                    
                    // Display the review (or message if no reviews)
                    $('#view-review-list').html(reviewsHtml);

                    // Show the modal to view the review
                    $('#viewReviewModal').modal('show');
                },
                error: function() {
                    alert('Không thể tải danh sách đánh giá.');
                }
        });
        // Hiển thị modal sau khi đã đổ sản phẩm
        $('#viewReviewModal').modal('show');

    });


 // Submit review
$('#submit-review').on('click', function (e) {
    e.preventDefault();

    // Clear previous error messages
    $('.error-message').remove(); // Xóa các thông báo lỗi cũ

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

    // Add CSRF token if Laravel is using CSRF protection
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

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
                // Đóng modal sau khi đánh giá thành công
                $('#reviewModal').modal('hide');
                // Thay đổi nút "Write Review" thành "View Review" sau khi đánh giá thành công
                var orderId = $('input[name="order_id"]').val();
                var button = $('button.open-review');
                button.text('Xem đánh giá').attr('disabled', true);
            }
        },
        error: function (xhr) {
            // Nếu gặp lỗi từ server (422 - đã đánh giá rồi)
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;

                // Hiển thị lỗi cụ thể cho mỗi trường
                if (xhr.responseJSON.message) {
                    Swal.fire({
                        title: 'Lỗi',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 6000,
                        showCloseButton: true
                    });
                }

                // Display error messages for each field
                if (errors.review_text) {
                    $('#review_text').after('<div class="error-message text-danger fw-bold">' + errors.review_text[0] + '</div>');
                }
                if (errors.rate) {
                    $('input[name="rate"]').closest('.rate').after('<div class="error-message text-danger">Mời bạn đánh giá sao !</div>');
                }
                if (errors.review_image) {
                    $('#review_image').after('<div class="error-message text-danger fw-bold">' + errors.review_image[0] + '</div>');
                }
            } else {
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra. Vui lòng thử lại.',
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 6000,
                    showCloseButton: true
                });
            }
        }
    });
});
    

    // Cập nhật ảnh
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
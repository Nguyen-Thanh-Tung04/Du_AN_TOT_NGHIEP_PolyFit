<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="Content-Security-Policy" content="script-src 'self' https://*.pusher.com; object-src 'none'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;"> --}}



    <title>Web Thời Trang FPoly Hà Nội</title>
    <meta name="keywords"
        content="apparel, catalog, clean, ecommerce, ecommerce HTML, electronics, fashion, html eCommerce, html store, minimal, multipurpose, multipurpose ecommerce, online store, responsive ecommerce template, shops" />
    <meta name="description" content="Best ecommerce html template for single and multi vendor store.">
    <meta name="author" content="ashishmaraviya">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- site Favicon -->
    <link rel="icon" href="{{asset('theme/client/assets/images/logo/logo1.png')}}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{asset('theme/client/assets/images/logo/logo1.png')}}" />
    <meta name="msapplication-TileImage" content="{{asset('theme/client/assets/images/logo/logo1.png')}}" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/vendor/ecicons.min.css')}}" />

    <!-- css All Plugins Files -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/countdownTimer.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/slick.min.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/plugins/sweetalert2.min.css')}}" />
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include jQuery (cần thiết cho Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/demo1.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/responsive.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/custom.css')}}" />



    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{asset('theme/client/assets/css/backgrounds/bg-4.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="{{asset('theme/client/assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Reviews --}}
    <link rel="stylesheet" id="bg-switcher-css" href="{{asset('theme/client/assets/css/review.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />
    <!-- Thêm CSS cho noUiSlider -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css" rel="stylesheet" />

    <!-- Thêm JS cho noUiSlider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>
    <!-- Thêm vào phần <head> của bạn -->


    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>

    <style>
        .ec-product-image {
            position: relative;
            overflow: hidden;
        }

        .ec-product-image .hover-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .ec-product-image:hover .hover-image {
            opacity: 1;
        }

        .ec-product-image .default-image {
            transition: opacity 0.3s ease-in-out;
        }

        .ec-product-image:hover .default-image {
            opacity: 0;
        }

    </style>


</head>

<body class="bg-white">
    @include('client.layouts.header')

    <main>
        @yield('title')
        @yield('content')
    </main>
    @vite(['resources/js/app.js'])
    @vite(['resources/js/order.js'])

    @include('client.layouts.footer')



    <!-- Vendor JS -->

    <script src="{{asset('theme/client/library/library.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/popper.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/modernizr-3.11.2.min.js')}}"></script>

    <!--Plugins JS-->
    <script src="{{asset('theme/client/assets/js/plugins/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/countdownTimer.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/scrollup.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/slick.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/infiniteslidev2.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/vendor/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/jquery.sticky-sidebar.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/plugins/sweetalert2.js')}}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        })

        function updateCartCount() {
            $.ajax({
                url: '{{ route("cart.count") }}',
                type: 'GET',
                success: function(data) {

                    if (data.count > 0) {
                        $('.cart-count-lable').text(data.count).show();
                    } else {
                        $('.cart-count-lable').hide();
                    }
                }
            });
        }
        var isLoggedIn = "{{ auth()->check() ? 'true' : 'false' }}";
        if (isLoggedIn == 'true') {
            updateCartCount();
        }
    </script>


    <!-- Main Js -->
    <script src="{{asset('theme/client/assets/js/vendor/index.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/main.js')}}"></script>
    <script src="{{ asset('theme/client/library/library.js') }}"></script>
    <script src="{{asset('theme/client/assets/js/review.js')}}"></script>

    @yield('scripts')
</body>

</html>
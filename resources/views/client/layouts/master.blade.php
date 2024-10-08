<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>PolyFit</title>
    <meta name="keywords"
        content="apparel, catalog, clean, ecommerce, ecommerce HTML, electronics, fashion, html eCommerce, html store, minimal, multipurpose, multipurpose ecommerce, online store, responsive ecommerce template, shops" />
    <meta name="description" content="Best ecommerce html template for single and multi vendor store.">
    <meta name="author" content="ashishmaraviya">

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

    <!-- Main Style -->
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/demo1.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/custom.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/client/assets/css/responsive.css')}}" />

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{asset('theme/client/assets/css/backgrounds/bg-4.css')}}">
    {{-- Reviews --}}
    <link rel="stylesheet" id="bg-switcher-css" href="{{asset('theme/client/assets/css/review.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />

<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>


</head>

<body>
    @include('client.layouts.header')

    <main>
        <h1>@yield('title')</h1>
        <p>@yield('content')</p>
    </main>

    @include('client.layouts.footer')


    <!-- Vendor JS -->
    <script src="{{asset('theme/client/assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
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
    </script>

    <!-- Main Js -->
    <script src="{{asset('theme/client/assets/js/vendor/index.js')}}"></script>
    <script src="{{asset('theme/client/assets/js/main.js')}}"></script>
    <script src="{{ asset('admin/library/location.js') }}"></script>
    {{-- <script src="{{ asset('admin/library/library.js') }}"></script> --}}
    <script src="{{asset('theme/client/assets/js/review.js')}}"></script>

    @yield('scripts')
</body>

</html>
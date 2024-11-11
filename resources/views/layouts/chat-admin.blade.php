<!DOCTYPE html>
<html>

<head>
    <base href="{{ config('app.url') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>INSPINIA | Dashboard v.2</title>

    <link href="admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="admin/css/animate.css" rel="stylesheet">
    <link href="admin/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/css/chat.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="admin/js/jquery-3.1.1.min.js"></script>
    @vite(['resources/js/app.js'])

    <style>
    .online_icon {
        position: absolute;
        height: 11px;
        width: 11px;
        left: 24px;
        top: 22px;
        background-color: #4cd137;
        border-radius: 50%;
        border: 1.5px solid white;
    }
    .user_info{
        margin: 5px 10px;
    }
    .is_active{
        position: absolute; 
        top: -12px;
        left: -10px;
        padding: 3px 0px;
    }
    </style>
</head>

<body>
    <div id="wrapper">
        @include('admin.dashboard.component.sidebar',['id' => $id_user_new])

        <div id="page-wrapper" class="gray-bg">
            @include('admin.dashboard.component.nav')
            @yield('content')
            @include('admin.dashboard.component.footer')
             @yield('script')
        </div>
    </div>

    <!-- Mainly scripts -->
    @include('admin.dashboard.component.script')
</body>

</html>
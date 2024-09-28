<!DOCTYPE html>
<html>

<head>
    @include('admin.dashboard.component.head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/switchery@0.8.2/dist/switchery.min.css">

</head>

<body>
    <div id="wrapper">
        @include('admin.dashboard.component.sidebar')

        <div id="page-wrapper" class="gray-bg">
            @include('admin.dashboard.component.nav')
            @yield('content')
            @include('admin.dashboard.component.footer')
        </div>
    </div>

    <!-- Mainly scripts -->
    @include('admin.dashboard.component.script')
</body>
</html>

<!DOCTYPE html>
<html>

<head>
    @include('admin.dashboard.component.head')
    @yield('css')
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
    @yield('js')
</body>
</html>

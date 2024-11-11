<!DOCTYPE html>
<html>

<head>
    @include('admin.dashboard.component.head')
    @vite(['resources/js/app.js'])
    @yield('css')
</head>

<body>
    <div id="wrapper">
        @include('admin.dashboard.component.sidebar', ['id' => $id_user_new])

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

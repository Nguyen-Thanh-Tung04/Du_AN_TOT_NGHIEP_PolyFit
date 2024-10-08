
<!DOCTYPE html>
<html>

<head>
    @include('admin.dashboard.component.head')
</head>

<body>
    <div id="wrapper">
        @include('admin.dashboard.component.sidebar')

        <div id="page-wrapper" class="gray-bg">
            @include('admin.dashboard.component.nav')
            @include($template)
            @include('admin.dashboard.component.footer')
        </div>
    </div>

    <!-- Mainly scripts -->
    @include('admin.dashboard.component.script')
</body>
</html>

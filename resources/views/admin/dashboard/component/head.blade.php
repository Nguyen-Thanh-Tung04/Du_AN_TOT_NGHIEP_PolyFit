<base href="{{ config('app.url') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>INSPINIA | Dashboard v.2</title>

    <link href="admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="admin/plugins/jquery-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (isset($config['css']) && is_array($config['css']))
        @foreach ($config['css'] as $key => $val)
            {!! '<link href="'.$val.'" rel="stylesheet">' !!}
        @endforeach
    @endif

    <link href="admin/css/animate.css" rel="stylesheet">
    <link href="admin/css/style.css" rel="stylesheet">
    <link href="admin/css/customize.css" rel="stylesheet">
    <script src="admin/js/jquery-3.1.1.min.js"></script>
    <script>
        var BASE_URL = '{{ config('app.url') }}'
        var SUFFIX = '{{ config('apps.general.suffix') }}'
    </script>
<base href="{{ config('app.url') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>INSPINIA | Dashboard v.2</title>

    <link href="admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="admin/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="admin/plugins/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="admin/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if (isset($config['css']) && is_array($config['css']))
        @foreach ($config['css'] as $key => $val)
            {!! '<link href="'.$val.'" rel="stylesheet">' !!}
        @endforeach
    @endif

    <link href="admin/css/animate.css" rel="stylesheet">
    <link href="admin/css/style.css" rel="stylesheet">
    <link href="admin/css/customize.css" rel="stylesheet">
    <script src="admin/js/jquery-3.1.1.min.js"></script>

    

    <link rel="stylesheet" href="admin/css/chat.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="admin/js/jquery-3.1.1.min.js"></script>
    @vite(['resources/js/app.js'])
    <script>
        var BASE_URL = '{{ config('app.url') }}'
        var SUFFIX = '{{ config('apps.general.suffix') }}'
    </script>

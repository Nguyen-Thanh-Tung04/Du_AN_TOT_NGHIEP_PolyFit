
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login 2</title>

    @include('admin.dashboard.component.head')

</head>

<body class="gray-bg">

<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-6">
            <h2 class="font-bold">Welcome to PolyFix</h2>

            <p>
                Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            </p>

            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
            </p>

            <p>
                When an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <p>
                <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
            </p>

        </div>
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="text-center">Đăng Ký</h2>
                <p class="text-center">Tạo tài khoản để xem nó hoạt động.</p>
                <form class="m-t" role="form" action="{{ route('auth.register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" name="name">
                        @error('name')
                        <span class="error-message">* {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        @error('email')
                        <span class="error-message">* {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        @error('password')
                        <span class="error-message">* {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Đồng ý với các điều khoản và chính sách </label></div>
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Đăng Ký</button>

                    <p class="text-muted text-center"><small>Bạn đã có tài khoản?</small></p>
                    <a class="btn btn-sm btn-white btn-block" href="{{ route('auth.login') }}">Đăng Nhập</a>
                </form>
                <p class="m-t">
                    <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
                </p>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Copyright Example Company
        </div>
        <div class="col-md-6 text-right">
            <small>© 2014-2015</small>
        </div>
    </div>
</div>

</body>

</html>

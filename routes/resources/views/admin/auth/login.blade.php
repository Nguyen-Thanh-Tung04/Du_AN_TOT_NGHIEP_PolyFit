
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trang Đăng Nhập</title>

    @include('admin.dashboard.component.head')

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Chào Mừng đến PolyFit+</h2>

                <p>
                    Chào bạn! Rất vui được chào đón bạn đến với hệ thống quản trị của Polyfit.
                </p>

                <p>
                    Với giao diện thân thiện và trực quan, chúng tôi cam kết mang đến cho bạn trải nghiệm tốt nhất trong việc quản lý sản phẩm, đơn hàng và khách hàng.
                </p>
                <p>
                    Nhập thông tin đăng nhập của bạn ở phía dưới để truy cập vào bảng điều khiển.
                </p>
                <p>
                    <small>Chào mừng bạn đến với Polyfit - Nơi khởi đầu cho những thành công mới!</small>
                </p>

            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <h2 class="text-center">Đăng Nhập</h2>
                    <form class="m-t" action="{{ route('auth.logined') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text"
                            class="form-control"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email">
                            @error('email')
                                <span class="error-message">* {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password"
                            class="form-control"
                            name="password"
                            placeholder="Password">
                            @error('password')
                                <span class="error-message">* {{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                        class="btn btn-primary block full-width m-b">Đăng Nhập</button>

                    </form>
                    <p class="m-t">
                        <small> <small>Chào mừng bạn đến với Polyfit - Nơi khởi đầu cho những thành công mới!</small></small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright Example PolyFit
            </div>
            <div class="col-md-6 text-right">
               <small>© 2024-2025</small>
            </div>
        </div>
    </div>

</body>

</html>

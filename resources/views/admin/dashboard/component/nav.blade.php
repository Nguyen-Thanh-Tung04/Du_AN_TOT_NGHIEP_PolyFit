<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        {{-- <form role="search" class="navbar-form-custom" action="search_results.html">
            <div class="form-group">
                <input type="text" placeholder="Tìm kiếm cái gì đó..." class="form-control" name="top-search" id="top-search">
            </div>
        </form> --}}
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li>
            <span class="m-r-sm text-muted welcome-message">Chào mừng bạn đến với trang quản trị</span>
        </li>


        <li>
            <a href="{{ route('auth.logout') }}">
                <i class="fa fa-sign-out"></i> Đăng xuất
            </a>
        </li>
    </ul>

</nav>

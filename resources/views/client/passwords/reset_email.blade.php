<div style="width: 600px; margin: 0 auto; text-align: center">
    <h2 class="ec-title">Xin chào {{ $customer->name }}</h2>
    <p class="sub-title mb-3">Email này để giúp bạn lấy lại mật khẩu tài khoản đã bị quên.</p>
    <p class="sub-title mb-3">Vui lòng click vào link dưới đây để đặt lại mật khẩu.</p>
    <p>
        <a href="{{ route('getPass', ['customer' => $customer->id, 'token' => $customer->token]) }}"
            style="display: inline-block; background: green; color: #fff; padding: 7px 25px; font-weight: bold">
            Đặt lại mật khẩu</a>
    </p>
</div>

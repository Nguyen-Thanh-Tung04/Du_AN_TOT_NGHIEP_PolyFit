@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Đặt lại mật khẩu</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Địa chỉ email</label>
            <input id="email" type="email" class="form-control" name="email" required autofocus>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Gửi liên kết đặt lại mật khẩu</button>
    </form>
</div>
@endsection

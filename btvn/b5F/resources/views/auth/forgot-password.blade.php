@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Quên mật khẩu</h2>
            <p>Nhập email đã đăng ký để nhận liên kết cấp lại mật khẩu.</p>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <button type="submit" class="btn btn-danger">Gửi email cấp lại mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection

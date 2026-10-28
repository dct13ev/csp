@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Đăng nhập</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <div class="form-check mb-3">
                    <input id="remember" type="checkbox" name="remember" class="form-check-input" value="1">
                    <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn btn-danger">Đăng nhập</button>
            </form>
        </div>
    </div>
</div>
@endsection

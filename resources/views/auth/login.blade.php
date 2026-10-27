@extends('layouts.master')

@section('title', 'Đăng nhập - Sensive Blog')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Đăng Nhập</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">Địa chỉ Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="Nhập email của bạn">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block font-weight-bold mt-4">Đăng Nhập</button>
                    </form>

                    <hr class="my-4">
                    <div class="text-center">
                        <p class="mb-0">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-primary font-weight-bold">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
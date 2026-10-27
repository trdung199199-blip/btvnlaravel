@extends('layouts.master')

@section('title', 'Đăng ký - Sensive Blog')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Đăng Ký Tài Khoản</h4>
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

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">Họ và Tên</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Nhập họ và tên">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Địa chỉ Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="Nhập email">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required placeholder="Mật khẩu ít nhất 6 ký tự">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Nhập lại mật khẩu">
                        </div>

                        <button type="submit" class="btn btn-success btn-block font-weight-bold mt-4">Đăng Ký</button>
                    </form>

                    <hr class="my-4">
                    <div class="text-center">
                        <p class="mb-0">Đã có tài khoản? <a href="{{ route('login') }}" class="text-success font-weight-bold">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
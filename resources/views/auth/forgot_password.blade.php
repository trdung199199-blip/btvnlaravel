@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center mb-4">Khôi phục mật khẩu</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nhập email tài khoản của bạn:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Gửi mật khẩu mới</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
@endsection
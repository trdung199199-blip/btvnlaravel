@extends('layouts.master')

@section('title', 'Thêm bài viết mới')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thêm bài viết mới</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                            
                        <div class="form-group">
                            <label class="font-weight-bold">Mô tả (Nội dung) <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Ảnh đại diện</label>
                            <input type="file" name="image_file" class="form-control-file" accept="image/*">
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary px-4">Đăng bài</button>
                        <a href="{{ route('post.index') }}" class="btn btn-secondary">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
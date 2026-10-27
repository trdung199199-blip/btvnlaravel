@extends('layouts.master')

@section('title', 'Sửa bài viết')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h4 class="mb-0 text-dark">Sửa bài viết</h4>
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

                    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Mô tả (Nội dung) <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="6" required>{{ old('description', $post->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Ảnh hiện tại:</label><br>
                            @if($post->file_path)
                                <img src="{{ asset($post->file_path) }}" alt="image" class="img-thumbnail mb-2" style="max-height: 150px;">
                            @else
                                <span class="text-muted italic">Chưa có ảnh</span><br>
                            @endif
                            <br>
                            <label class="font-weight-bold mt-2">Chọn ảnh mới (Nếu muốn đổi)</label>
                            <input type="file" name="image_file" class="form-control-file" accept="image/*">
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-warning px-4 font-weight-bold">Cập nhật</button>
                        <a href="{{ route('post.index') }}" class="btn btn-secondary">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
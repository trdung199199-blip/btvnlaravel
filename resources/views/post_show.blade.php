@extends('layouts.master')

@section('title', $post->title)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent px-0">
                    <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết bài viết</li>
                </ol>
            </nav>

            <h1 class="font-weight-bold mb-3">{{ $post->title }}</h1>
            
            <div class="text-muted mb-4 d-flex justify-content-between align-items-center">
                <span><i class="far fa-calendar-alt"></i> Ngày đăng: {{ $post->created_at->format('d/m/Y H:i') }}</span>
                <div class="btn-group">
                    @can('update-post', $post)
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-warning">Sửa bài</a>
                    @endcan
                    @can('delete-post', $post)
                        <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline ml-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa bài này?')">Xóa bài</button>
                        </form>
                    @endcan
                </div>
            </div>

            @if($post->file_path)
                <div class="text-center mb-5">
                    <img src="{{ asset($post->file_path) }}" class="img-fluid rounded shadow-sm" alt="{{ $post->title }}">
                </div>
            @endif

            <div class="post-content" style="font-size: 1.1rem; line-height: 1.8;">
                {!! nl2br(e($post->description)) !!}
            </div>

            <hr class="my-5">
            <a href="{{ route('post.index') }}" class="btn btn-outline-primary">&larr; Quay lại danh sách</a>
        </div>
    </div>
</div>
@endsection
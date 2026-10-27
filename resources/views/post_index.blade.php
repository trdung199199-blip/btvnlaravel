@extends('layouts.master')

@section('title', 'Sensive - Trang Chủ Blog Tin Tức')

@section('content')

<section class="hero-banner text-center mb-5">
    <div class="container">
        <h1 class="display-4 font-weight-bold">Sensive Blog</h1>
        <p class="lead">Chia sẻ kiến thức, tin tức công nghệ và phong cách sống</p>
    </div>
</section>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="font-weight-bold mb-0">Bài Viết Mới Nhất</h3>
                {{-- Nút thêm bài viết (Nếu đã đăng nhập) --}}
                @auth
                    <a href="{{ route('post.create') }}" class="btn btn-primary">+ Viết bài mới</a>
                @endauth
            </div>

            @if(count($posts) > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6">
                            <div class="card blog-card">
                                {{-- Hiển thị ảnh thật hoặc ảnh mặc định --}}
                                <img src="{{ $post->file_path ? asset($post->file_path) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $post->title }}">
                                
                                <div class="card-body">
                                    <small class="text-muted">Đăng ngày {{ $post->created_at->format('d/m/Y') }}</small>
                                    <h5 class="card-title font-weight-bold mt-2">
                                        <a href="{{ route('post.show', $post->id) }}" class="text-dark">{{ $post->title }}</a>
                                    </h5>
                                    <p class="card-text text-secondary">{{ Str::limit($post->description, 100) }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="{{ route('post.show', $post->id) }}" class="btn btn-outline-primary btn-sm">Đọc tiếp &rarr;</a>
                                        
                                        {{-- Nhóm nút Sửa/Xóa (Chỉ hiện nếu đúng tác giả) --}}
                                        <div class="btn-group">
                                            @can('update-post', $post)
                                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                            @endcan
                                            @can('delete-post', $post)
                                                <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xóa bài này?')">Xóa</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">Hiện chưa có bài viết nào được đăng!</div>
            @endif
        </div>

        {{-- Sidebar giữ nguyên --}}
        <div class="col-lg-4">
            <div class="sidebar-widget text-center">
                <img src="https://via.placeholder.com/100" class="rounded-circle mb-3" alt="Author">
                <h5 class="font-weight-bold">Admin Blog</h5>
                <p class="text-muted small">Chào mừng bạn đến với Blog cá nhân của tôi. Nơi chia sẻ đam mê và thông tin hữu ích mỗi ngày.</p>
            </div>
        </div>
    </div>
</div>
@endsection
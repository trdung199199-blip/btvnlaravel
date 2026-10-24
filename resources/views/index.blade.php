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
    <div class="row">
        <div class="col-lg-8">
            <h3 class="mb-4 font-weight-bold">Bài Viết Mới Nhất</h3>

            @if(count($posts) > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6">
                            <div class="card blog-card">
                                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="{{ $post->title }}">
                                <div class="card-body">
                                    <small class="text-muted">Đăng ngày {{ $post->created_at }}</small>
                                    <h5 class="card-title font-weight-bold mt-2">
                                        <a href="/posts/{{ $post->id }}" class="text-dark">{{ $post->title }}</a>
                                    </h5>
                                    <p class="card-text text-secondary">{{ Str::limit($post->description, 100) }}</p>
                                    <a href="/posts/{{ $post->id }}" class="btn btn-outline-primary btn-sm">Đọc tiếp &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">Hiện chưa có bài viết nào được đăng!</div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="sidebar-widget text-center">
                <img src="https://via.placeholder.com/100" class="rounded-circle mb-3" alt="Author">
                <h5 class="font-weight-bold">Admin Blog</h5>
                <p class="text-muted small">Chào mừng bạn đến với Blog cá nhân của tôi. Nơi chia sẻ đam mê và thông tin hữu ích mỗi ngày.</p>
            </div>

            <div class="sidebar-widget">
                <h5 class="font-weight-bold mb-3">Danh Mục</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        Công Nghệ <span class="badge badge-primary badge-pill">12</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        Lập Trình <span class="badge badge-primary badge-pill">8</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        Cuộc Sống <span class="badge badge-primary badge-pill">5</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
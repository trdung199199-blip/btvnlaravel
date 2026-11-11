@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 Thống kê</h2>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tổng thành viên</h5>
                    <h2 class="card-text">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Bài viết đã xuất bản</h5>
                    <h2 class="card-text">{{ $totalPosts }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tổng số bình luận</h5>
                    <h2 class="card-text">{{ $totalComments }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Top 5 Bài Viết Nhiều Bình Luận Nhất</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="55%">Tiêu đề bài viết</th>
                        <th width="20%">Tác giả</th>
                        <th width="20%" class="text-center">Số bình luận</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPosts as $key => $post)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td>{{ $post->user->name ?? 'Ẩn danh' }}</td>
                            <td class="text-center">
                                <span class="badge bg-danger rounded-pill">{{ $post->comments_count }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Chưa có dữ liệu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
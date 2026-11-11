@extends('layouts.master')

@section('content')
    <div class="container mt-4">
    <h2 class="mb-4">Danh sách bài viết</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @auth
        <div>
            @can('admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-info text-white me-2">
                    📊 Thống kê
                </a>
                <a href="{{ route('admin.category.index') }}" class="btn btn-warning text-dark me-2">
                    📁 Quản lý Danh mục
                </a>
            @endcan

            <a href="{{ route('post.create') }}" class="btn btn-success me-2">
                + Thêm bài viết
            </a>
            <a href="{{ route('post.trash') }}" class="btn btn-outline-danger">
                🗑️ Thùng rác
            </a>
        </div>
    @endauth

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('post.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm từ khóa..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="tag_id" class="form-select">
                        <option value="">-- Tất cả thẻ (Tag) --</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($posts as $post)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            @if($post->file_path)
                <img src="{{ asset($post->file_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
            @else
                <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="No image">
            @endif

            <div class="card-body">
                @if($post->status === 'draft')
                    <span class="badge bg-warning text-dark mb-2">Bản nháp</span>
                @elseif($post->status === 'scheduled')
                    <span class="badge bg-info text-dark mb-2">
                        ⏰ Sắp đăng: {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'Chưa xếp lịch' }}
                    </span>
                @endif

                <h5 class="card-title">
                    <a href="{{ route('post.show', $post->slug) }}" class="text-decoration-none text-dark">{{ $post->title }}</a>
                </h5>
                <p class="text-muted small mb-2">
                    Tác giả: {{ $post->user->name ?? 'Ẩn danh' }} | 
                    Danh mục: {{ $post->category->name ?? 'Không có' }}
                </p>
                <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
            </div>

            <div class="card-footer bg-white border-top-0">
                @if($post->status === 'draft')
                    @can('update-post', $post)
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-warning me-1 mr-1">Hoàn thành</a>
                    @endcan

                    @can('delete-post', $post)
                        <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Chuyển bài viết vào thùng rác?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                        </form>
                    @endcan

                @elseif($post->status === 'scheduled')
                    @can('update-post', $post)
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-warning me-1 mr-1">Sửa</a>
                    @endcan

                    @can('delete-post', $post)
                        <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Chuyển bài viết vào thùng rác?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                        </form>
                    @endcan

                @else
                    <a href="{{ route('post.show', $post->slug) }}" class="btn btn-sm btn-outline-primary">Đọc tiếp</a>
                    
                    @can('update-post', $post)
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-warning">Sửa</a>
                    @endcan

                    @can('delete-post', $post)
                        <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                        </form>
                    @endcan
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info">Không tìm thấy bài viết nào.</div>
    </div>
@endforelse
    <div>
        <div class="d-flex justify-content-center mt-3">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
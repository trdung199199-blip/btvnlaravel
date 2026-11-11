@extends('layouts.master')

@section('content')
<div class="container mt-4 mb-5">
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <article class="blog-post">
        <h1 class="mb-3">{{ $post->title }}</h1>
        <p class="text-muted">
            Đăng bởi <strong>{{ $post->user->name ?? 'Ẩn danh' }}</strong> 
            vào {{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : $post->created_at->format('d/m/Y H:i') }}
            | Danh mục: <span class="badge bg-primary text-white">{{ $post->category->name ?? 'Không có' }}</span>
        </p>

        <div class="mb-4">
            @foreach($post->tags as $tag)
                <span class="badge bg-info text-dark">#{{ $tag->name }}</span>
            @endforeach
        </div>

        @if($post->file_path)
            <div class="text-center mb-4">
                <img src="{{ asset($post->file_path) }}" class="img-fluid rounded" alt="{{ $post->title }}" style="max-height: 500px;">
            </div>
        @endif

        <div class="post-content fs-5" style="white-space: pre-wrap;">
            {{ $post->description }}
        </div>
    </article>

    <hr class="my-5">

    <section class="comments-section">
        <h4 class="mb-4">Bình luận ({{ $post->comments->count() }})</h4>

        @auth
            <form action="{{ route('comment.store', $post->id) }}" method="POST" class="mb-5">
                @csrf
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
            </form>
        @else
            <div class="alert alert-warning">
                Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để lại bình luận.
            </div>
        @endauth

        <div class="comments-list">
            @forelse($post->comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold mb-1">{{ $comment->user->name ?? 'Ẩn danh' }}</h6>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-2">{{ $comment->content }}</p>
                        
                        @can('delete-comment', $comment)
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0">Xóa</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
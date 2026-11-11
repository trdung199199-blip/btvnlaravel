@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Thùng rác của tôi</h2>
        <a href="{{ route('post.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="40%">Tiêu đề bài viết</th>
                            <th width="20%">Danh mục</th>
                            <th width="15%">Ngày xóa</th>
                            <th width="20%" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $key => $post)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <strong>{{ $post->title }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $post->category->name ?? 'Không có' }}</span>
                                </td>
                                <td>
                                    {{ $post->deleted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('post.restore', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn muốn khôi phục bài viết này?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Khôi phục</button>
                                    </form>

                                    <form action="{{ route('post.forceDelete', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('CẢNH BÁO: Hành động này không thể hoàn tác. Xóa vĩnh viễn bài viết?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa vĩnh viễn</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Thùng rác đang trống.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
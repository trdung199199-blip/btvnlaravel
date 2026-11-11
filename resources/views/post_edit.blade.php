@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h2>Chỉnh Sửa Bài Viết</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề bài viết <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Thẻ (Tags)</label>
                <div>
                    @php
                        $currentTagIds = $post->tags->pluck('id')->toArray();
                    @endphp
                    
                    @foreach($tags as $tag)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tags[]" id="tag_{{ $tag->id }}" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $currentTagIds)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Nội dung <span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" id="description" rows="5" required>{{ old('description', $post->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image_file" class="form-label">Ảnh đại diện</label>
                @if($post->file_path)
                    <div class="mb-2">
                        <img src="{{ asset($post->file_path) }}" alt="Ảnh hiện tại" width="150" class="img-thumbnail">
                    </div>
                @endif
                <input type="file" class="form-control" name="image_file" id="image_file" accept="image/*">
                <small class="text-muted">Bỏ trống nếu không muốn thay đổi ảnh.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Lưu nháp</option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Đăng ngay</option>
                        <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Hẹn giờ đăng</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3" id="schedule_box" style="display: none;">
                    <label for="published_at" class="form-label">Thời gian đăng</label>
                    <input type="datetime-local" class="form-control" name="published_at" id="published_at" 
                        value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Cập nhật bài viết</button>
            <a href="{{ route('post.index') }}" class="btn btn-secondary mt-3">Hủy</a>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusSelect = document.getElementById('status');
            const scheduleBox = document.getElementById('schedule_box');

            function toggleScheduleBox() {
                if (statusSelect.value === 'scheduled') {
                    scheduleBox.style.display = 'block';
                } else {
                    scheduleBox.style.display = 'none';
                }
            }

            statusSelect.addEventListener('change', toggleScheduleBox);
            toggleScheduleBox();
        });
    </script>
@endsection
@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h2>Thêm Bài Viết Mới</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề bài viết <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Thẻ (Tags)</label>
                <div>
                    @foreach($tags as $tag)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="tags[]" id="tag_{{ $tag->id }}" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Nội dung <span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" id="description" rows="5" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image_file" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" name="image_file" id="image_file" accept="image/*">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Lưu nháp</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Đăng ngay</option>
                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Hẹn giờ đăng</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3" id="schedule_box" style="display: none;">
                    <label for="published_at" class="form-label">Thời gian đăng</label>
                    <input type="datetime-local" class="form-control" name="published_at" id="published_at" value="{{ old('published_at') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Lưu bài viết</button>
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
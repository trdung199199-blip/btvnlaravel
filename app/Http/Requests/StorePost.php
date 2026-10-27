<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
    /**
     * Xác định quyền sử dụng Request này
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Chỉ validate định dạng và dung lượng ảnh
     */
    public function rules(): array
    {
        return [
            // Bắt buộc là file ảnh, định dạng jpeg/png/jpg/gif, tối đa 2MB (2048 KB)
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (Tiếng Việt)
     */
    public function messages(): array
    {
        return [
            'image_file.image' => 'File tải lên bắt buộc phải là hình ảnh.',
            'image_file.mimes' => 'Ảnh chỉ hỗ trợ định dạng: jpeg, png, jpg, gif, webp.',
            'image_file.max' => 'Dung lượng ảnh tải lên không được vượt quá 2MB.',
        ];
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'slug' => 'huong-dan-hoc-laravel-tu-co-ban-den-nang-cao',
                'title' => 'Hướng dẫn học Laravel từ cơ bản đến nâng cao cho người mới',
                'description' => 'Laravel là một trong những PHP Framework phổ biến nhất hiện nay nhờ cú pháp rõ ràng, hiện đại và hệ sinh thái phong phú giúp tối ưu hóa tốc độ phát triển web.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'top-5-meo-toi-uu-hieu-nang-cho-website-php',
                'title' => 'Top 5 mẹo tối ưu hiệu năng cho website PHP của bạn',
                'description' => 'Tìm hiểu cách sử dụng Cache, tối ưu hóa truy vấn Database Query Builder, và nâng cấp phiên bản PHP để giúp ứng dụng chạy nhanh gấp đôi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'tim-hieu-ve-blade-template-engine-trong-laravel',
                'title' => 'Tìm hiểu về Blade Template Engine và cách chia Layout',
                'description' => 'Blade là Template Engine mạnh mẽ tích hợp sẵn trong Laravel, hỗ trợ sử dụng các directive như @extends, @section, @include giúp cấu trúc giao diện gọn gàng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'xay-dung-giao-dien-responsive-voi-bootstrap-4',
                'title' => 'Xây dựng giao diện Responsive chuyên nghiệp với Bootstrap 4',
                'description' => 'Bootstrap 4 giúp bạn dễ dàng chia cột Grid System, tạo Navigation Bar và các thành phần UI hiển thị mượt mà trên mọi thiết bị di động.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'ly-do-nen-su-dung-query-builder-thay-vi-raw-sql',
                'title' => 'Lý do nên sử dụng Query Builder trong dự án thực tế',
                'description' => 'Laravel Query Builder giúp viết truy vấn CSDL an toàn chống SQL Injection, giao diện lập trình hướng đối tượng fluent interface rất dễ đọc và bảo trì.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
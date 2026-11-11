<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-scheduled-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hoàn thành việc xuất bản các bài viết đã lên lịch';

    /**
     * Execute the console command.
     */
    public function handle()
    {   
        $updatedCount = Post::where('status', 'scheduled')
            ->where('published_at', '<=', now())
            ->update([
                'status' => 'published'
            ]);

        $this->info("Đã xuất bản thành công {$updatedCount} bài viết hẹn giờ.");
    }
}

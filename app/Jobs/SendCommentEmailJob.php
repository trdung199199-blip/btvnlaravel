<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Models\Comment;
use App\Mail\CommentNotificationMail;

class SendCommentEmailJob implements ShouldQueue
{
    use Queueable, SerializesModels, Dispatchable;

    public $comment;    
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $author = $this->comment->post->user;

        if ($author && $author->email) {
            Mail::to($author->email)->send(new CommentNotificationMail($this->comment));
        }
    }
}

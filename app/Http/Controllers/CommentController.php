<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;    
use App\Jobs\SendCommentEmailJob;

class CommentController extends Controller
{
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'content' => 'required|max:1000'
        ]);

        $post = Post::findOrFail($post_id);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->input('content')
        ]);
        SendCommentEmailJob::dispatch($comment);

        return back()->with('success', 'Đã thêm bình luận!');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::with('post')->findOrFail($id);
        Gate::authorize('delete-comment', $comment);

        $comment->delete();
        
        return back()->with('success', 'Đã xóa bình luận thành công');
    }
}
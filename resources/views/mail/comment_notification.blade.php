<div style="font-family: Arial, sans-serif; padding: 20px;">
    <h3>Chào {{ $comment->post->user->name }},</h3>
    <p>Bài viết <strong>"{{ $comment->post->title }}"</strong> vừa có bình luận mới từ <strong>{{ $comment->user->name ?? 'Một độc giả' }}</strong>:</p>
    
    <blockquote style="background: #f4f4f4; padding: 10px; border-left: 5px solid #007bff;">
        {{ $comment->content }}
    </blockquote>
    
    <p>Thời gian: {{ $comment->created_at->format('d/m/Y H:i') }}</p>
</div>
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers    = User::count();
        $totalPosts    = Post::where('status', 'published')->count();
        $totalComments = Comment::whereHas('post')->count();

        $topPosts = Post::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();

        return view('admin_dashboard', 
        compact('totalUsers', 'totalPosts', 'totalComments', 'topPosts'));
    }
}
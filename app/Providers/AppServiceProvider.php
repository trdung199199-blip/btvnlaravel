<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment; // Thêm model Comment
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });
        
        Gate::define('delete-post', function (User $user, Post $post) {
            return $user->id === $post->user_id || $user->is_admin;
        });

        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('delete-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id 
                || $user->id === $comment->post->user_id 
                || $user->is_admin;
        });
        Paginator::useBootstrapFive();
    }
}
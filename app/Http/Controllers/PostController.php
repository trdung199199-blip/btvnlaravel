<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index(Request $request) {
    $query = Post::with(['user', 'category', 'tags'])
        ->where(function ($q) {
            //Lấy các bài viết đã xuất bản và đã đến thời gian đăng
            $q->where(function ($sub) {
                $sub->where('status', 'published')
                    ->where('published_at', '<=', now());
            });

            //lấy thêm tất cả bài viết thuộc về tác giả đang đăng nhập
            if (auth()->check()) {
                $q->orWhere('user_id', auth()->id());
            }
        })
        ->latest();

        // Tìm kiếm theo từ khóa tiêu đề hoặc nội dung
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo tag
        if ($request->filled('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        $posts = $query->paginate(6)->withQueryString();
        $categories = Category::all();
        $tags = Tag::all();

        Log::critical("daily check info: ", ['user' => Auth::user()]);

        return view('post_index', compact('posts', 'categories', 'tags'));
    }

    public function show($slug) {
        $post = Post::with(['user', 'category', 'tags', 'comments.user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('post_show', ['post' => $post]);
    }
    public function create() {
        $categories = Category::all();
        $tags = Tag::all();
        return view('post_create', compact('categories', 'tags'));
    }

    public function store(StorePost $request) {
        $post = new Post();

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            if ($file->isValid()) {
                $file_name = date('Ymd') . random_int(10000, 10000000) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload'), $file_name);
                $post->file_path = 'upload/' . $file_name;
            }
        }

        $post->user_id = Auth::id();
        $post->title = $request->title ?? 'default';
        $post->slug = Str::slug($request->title) . '-' . time();
        $post->description = $request->description ?? 'default';
        $post->category_id = $request->category_id;
        $post->status = $request->status ?? 'draft';
        $post->published_at = ($request->status === 'scheduled') ? $request->published_at : now();

        $post->save();

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('post.index')->with('success', 'Thêm bài viết thành công');
    }

    public function edit($id) {
        $post = Post::with('tags')->findOrFail($id);
        Gate::authorize('update-post', $post);

        $categories = Category::all();
        $tags = Tag::all();

        return view('post_edit', compact('post', 'categories', 'tags'));
    }

    public function update(StorePost $request, $id) {
        $post = Post::findOrFail($id);
        Gate::authorize('update-post', $post);

        $post->title = $request->title;
        $post->slug = Str::slug($request->title) . '-' . time();
        $post->description = $request->description;
        $post->category_id = $request->category_id;
        $post->status = $request->status;
        $post->published_at = ($request->status === 'scheduled') ? $request->published_at : ($post->published_at ?? now());

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $file_name = date('Ymd') . random_int(10000, 10000000) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload'), $file_name);

            if ($post->file_path && file_exists(public_path($post->file_path))) {
                unlink(public_path($post->file_path));
            }

            $post->file_path = 'upload/' . $file_name;
        }

        $post->save();
        // Cập nhật lại các tag liên kết
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('post.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (auth()->user()->is_admin && auth()->id() !== $post->user_id) {
            
            if ($post->file_path && file_exists(public_path($post->file_path))) {
                unlink(public_path($post->file_path));
            }

            $post->forceDelete(); 
            
            return back()->with('success', 'Đã xóa vĩnh viễn bài viết vi phạm!');
        }

        $post->delete();
        
        return back()->with('success', 'Đã chuyển bài viết vào thùng rác!');
    }

    public function trash() {
        $posts = Post::onlyTrashed()->where('user_id', Auth::id())->get();
        return view('post_trash', compact('posts'));
    }

    public function restore($id) {
        $post = Post::onlyTrashed()->findOrFail($id);
        Gate::authorize('update-post', $post);

        $post->restore();

        return redirect()->route('post.trash')->with('success', 'Khôi phục bài viết thành công');
    }

    public function forceDelete($id) {
        $post = Post::onlyTrashed()->findOrFail($id);
        Gate::authorize('delete-post', $post);

        if ($post->file_path && file_exists(public_path($post->file_path))) {
            unlink(public_path($post->file_path));
        }

        $post->forceDelete();

        return redirect()->route('post.trash')->with('success', 'Đã xóa bài viết vĩnh viễn');
    }
}
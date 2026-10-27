<?php
namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('user')->get();
        return view('post_index', ['posts' => $posts]);
    }

    public function show($id) {
        $post = Post::select('id', 'slug', 'title', 'description', 'file_path', 'created_at', 'updated_at')
            ->where('id', $id)->firstOrFail();
        return view('post_show', ['post' => $post]);
    }

    public function create() {
        return view('post_create');
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
        $post->slug = Str::slug($request->title);
        $post->description = $request->description ?? 'default'; 
        
        $post->save();
        return redirect()->route('post.index')->with('success', 'Thêm bài viết thành công');
    }

    public function edit($id) {
        $post = Post::findOrFail($id); 
        Gate::authorize('update-post', $post);
        return view('post_edit', ['post' => $post]);
    }

    public function update(StorePost $request, $id) {
        $post = Post::findOrFail($id);
        Gate::authorize('update-post', $post);

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
   
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $file_name = date('Ymd') . random_int(10000, 10000000) . '.' . $file->getClientOriginalExtension();
            $file->move('upload', $file_name);

            if ($post->file_path && file_exists(public_path($post->file_path))) {
                unlink(public_path($post->file_path));
            }

            $post->file_path = 'upload/' . $file_name;
        }

        $post->save();
        return redirect()->route('post.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id) {
        $post = Post::withTrashed()->findOrFail($id);
        Gate::authorize('delete-post', $post);

        if ($post->trashed()) {
            if ($post->file_path && file_exists(public_path($post->file_path))) {
                unlink(public_path($post->file_path));
            }
            $post->forceDelete();
        } else {
            $post->delete();
        }
        
        return redirect()->route('post.index')->with('success', 'Xóa bài viết thành công');
    }
}
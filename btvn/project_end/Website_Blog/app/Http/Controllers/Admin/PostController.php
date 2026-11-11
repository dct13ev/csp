<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->slug = Str::slug($request->title).'-'.time();
        $post->content = $request->input('content');
        $post->category_id = $request->category_id;
        $post->status = $request->status;

        if ($request->status === 'published') {
            $post->published_at = Carbon::now();
        } elseif ($request->status === 'scheduled' && $request->filled('published_at')) {
            $post->published_at = $request->published_at;
        }

        $post->user_id = auth()->id();
        $post->save();

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        Log::channel('blog')->info('Bài viết mới được tạo.', [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'status' => $post->status,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Đã thêm bài viết mới thành công!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        Gate::authorize('update', $post);
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        $post = Post::findOrFail($id);
        Gate::authorize('update', $post);
        $post->title = $request->title;
        $post->slug = Str::slug($request->title).'-'.time();
        $post->content = $request->input('content');
        $post->category_id = $request->category_id;
        $post->status = $request->status;

        if ($request->status === 'published' && $post->published_at === null) {
            $post->published_at = Carbon::now();
        }

        $post->save();

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        Log::channel('blog')->info('Bài viết đã được cập nhật.', [
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'status' => $post->status,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        Gate::authorize('delete', $post);
        $post->delete();

        Log::channel('blog')->info('Bài viết đã được đưa vào thùng rác.', [
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được xóa thành công.');
    }
}

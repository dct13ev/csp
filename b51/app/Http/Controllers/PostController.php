<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();

        return view('post_index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load('user');

        return view('post_show', compact('post'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('post_create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        Post::create($validated);

        return redirect()->route('post.index');
    }

    public function edit(Post $post)
    {
        $users = User::orderBy('name')->get(['id', 'name']);

        return view('post_edit', compact('post', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $post->update($validated);

        return redirect()->route('post.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('post.index');
    }
}

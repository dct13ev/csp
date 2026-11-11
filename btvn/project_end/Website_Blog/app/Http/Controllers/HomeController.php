<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
                    ->where('status', 'published')
                    ->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->paginate(6)->appends($request->all());
        
        $categories = Category::all();

        return view('home', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'comments.user', 'tags'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        return view('show', compact('post'));
    }

    public function category($id)
    {

        $currentCategory = Category::findOrFail($id);

        $posts = Post::with(['user', 'category'])
            ->where('category_id', $id)
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        $categories = Category::all();

        return view('home', compact('posts', 'categories', 'currentCategory'));
    }

    public function tag($slug)
    {
        $currentTag = \App\Models\Tag::where('slug', $slug)->firstOrFail();

        $posts = $currentTag->posts()
            ->with(['user', 'category'])
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        $categories = Category::all();

        return view('home', compact('posts', 'categories', 'currentTag'));
    }
}


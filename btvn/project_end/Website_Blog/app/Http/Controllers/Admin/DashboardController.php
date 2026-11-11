<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Post, Comment};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'posts' => Post::count(),
            'comments' => Comment::count(),
        ];
        $topPosts = Post::withCount('comments')->orderByDesc('comments_count')->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'topPosts'));
    }
}

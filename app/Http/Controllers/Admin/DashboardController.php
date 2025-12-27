<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_users' => User::count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
        ];

        $recent_posts = Post::with('user', 'categories')
            ->latest()
            ->take(5)
            ->get();

        $recent_comments = Comment::with('post', 'user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_comments'));
    }
}
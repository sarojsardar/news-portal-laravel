<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPosts = Post::published()
            ->featured()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->take(5)
            ->get();

        $breakingNews = Post::published()
            ->breaking()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->take(3)
            ->get();

        $latestPosts = Post::published()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->take(10)
            ->get();

        $categories = Category::where('is_active', true)
            ->where('show_on_menu', true)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.home', compact('featuredPosts', 'breakingNews', 'latestPosts', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $posts = Post::published()
            ->whereHas('categories', function($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.category', compact('category', 'posts'));
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->with(['user', 'categories', 'tags', 'comments.user'])
            ->firstOrFail();

        // Record view
        $post->increment('views_count');

        $relatedPosts = Post::published()
            ->whereHas('categories', function($query) use ($post) {
                $query->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->where('id', '!=', $post->id)
            ->take(4)
            ->get();

        return view('frontend.post', compact('post', 'relatedPosts'));
    }

    public function search()
    {
        $query = request('q');
        
        $posts = Post::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.search', compact('posts', 'query'));
    }
}
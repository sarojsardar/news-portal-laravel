@extends('layouts.app')

@section('title', 'Home - News Portal')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <!-- Breaking News -->
        @if($breakingNews->count() > 0)
        <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
            <h2 class="text-lg font-bold mb-3">
                <i class="fas fa-bolt mr-2"></i>Breaking News
            </h2>
            <div class="space-y-2">
                @foreach($breakingNews as $news)
                <div class="border-b border-red-500 pb-2 last:border-b-0">
                    <a href="{{ route('post', $news->slug) }}" class="hover:underline">
                        {{ $news->title }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Featured Posts -->
        @if($featuredPosts->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Featured Stories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($featuredPosts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            @foreach($post->categories as $category)
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-2">{{ $category->name }}</span>
                            @endforeach
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('post', $post->slug) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                        </h3>
                        @if($post->excerpt)
                        <p class="text-gray-600 text-sm">{{ Str::limit($post->excerpt, 100) }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-3 text-sm text-gray-500">
                            <span>By {{ $post->user->name }}</span>
                            <span><i class="fas fa-eye mr-1"></i>{{ $post->views_count }}</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Latest Posts -->
        <div>
            <h2 class="text-2xl font-bold mb-4">Latest News</h2>
            <div class="space-y-6">
                @foreach($latestPosts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden flex">
                    @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-32 h-24 object-cover flex-shrink-0">
                    @endif
                    <div class="p-4 flex-1">
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            @foreach($post->categories as $category)
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-2">{{ $category->name }}</span>
                            @endforeach
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('post', $post->slug) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                        </h3>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>By {{ $post->user->name }}</span>
                            <span><i class="fas fa-eye mr-1"></i>{{ $post->views_count }}</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Categories -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-lg font-bold mb-4">Categories</h3>
            <div class="space-y-2">
                @foreach($categories as $category)
                <a href="{{ route('category', $category->slug) }}" class="block text-gray-700 hover:text-blue-600 py-1">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Popular Posts -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-lg font-bold mb-4">Popular Posts</h3>
            <div class="space-y-3">
                @foreach(\App\Models\Post::published()->orderBy('views_count', 'desc')->take(5)->get() as $popular)
                <div class="flex space-x-3">
                    @if($popular->featured_image)
                    <img src="{{ Storage::url($popular->featured_image) }}" alt="{{ $popular->title }}" class="w-16 h-12 object-cover rounded">
                    @endif
                    <div class="flex-1">
                        <a href="{{ route('post', $popular->slug) }}" class="text-sm font-medium hover:text-blue-600 line-clamp-2">
                            {{ $popular->title }}
                        </a>
                        <p class="text-xs text-gray-500 mt-1">{{ $popular->published_at->format('M d') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
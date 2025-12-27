@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-newspaper text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Posts</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_posts'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Published</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['published_posts'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-edit text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Drafts</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['draft_posts'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Users</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Posts -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Posts</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recent_posts as $post)
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $post->title }}</p>
                        <p class="text-sm text-gray-500">By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.posts.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                    View all posts →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Comments -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Recent Comments</h3>
        </div>
        <div class="p-6">
            @if($recent_comments->count() > 0)
            <div class="space-y-4">
                @foreach($recent_comments as $comment)
                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $comment->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($comment->status) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900">{{ Str::limit($comment->content, 60) }}</p>
                        <p class="text-sm text-gray-500">
                            On "{{ $comment->post->title }}" • {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-sm">No comments yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
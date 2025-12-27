<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Language;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $posts = Post::with(['user', 'categories', 'tags'])
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $tags = Tag::all();
        $languages = Language::where('is_active', true)->get();

        return view('admin.posts.create', compact('categories', 'tags', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:300',
            'content' => 'required',
            'type' => 'required|in:article,video,gallery,poll,live',
            'status' => 'required|in:draft,published,archived',
            'language_id' => 'required|exists:languages,id',
            'categories' => 'required|array',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post = new Post($request->all());
        $post->slug = Str::slug($request->title);
        $post->user_id = auth()->id();
        
        if ($request->status === 'published' && !$request->published_at) {
            $post->published_at = now();
        }

        if ($request->hasFile('featured_image')) {
            $imagePaths = $this->imageService->upload($request->file('featured_image'), 'posts');
            $post->featured_image = $imagePaths['medium'];
        }

        $post->save();

        $post->categories()->sync($request->categories);
        
        if ($request->tags) {
            $tagIds = [];
            foreach (explode(',', $request->tags) as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)], ['slug' => Str::slug(trim($tagName))]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'categories', 'tags', 'comments.user']);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::where('is_active', true)->get();
        $tags = Tag::all();
        $languages = Language::where('is_active', true)->get();
        $post->load(['categories', 'tags']);

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'languages'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:300',
            'content' => 'required',
            'type' => 'required|in:article,video,gallery,poll,live',
            'status' => 'required|in:draft,published,archived',
            'language_id' => 'required|exists:languages,id',
            'categories' => 'required|array',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $post->fill($request->all());
        $post->slug = Str::slug($request->title);
        
        if ($request->status === 'published' && !$post->published_at) {
            $post->published_at = now();
        }

        if ($request->hasFile('featured_image')) {
            $imagePaths = $this->imageService->upload($request->file('featured_image'), 'posts');
            $post->featured_image = $imagePaths['medium'];
        }

        $post->save();

        $post->categories()->sync($request->categories);
        
        if ($request->tags) {
            $tagIds = [];
            foreach (explode(',', $request->tags) as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)], ['slug' => Str::slug(trim($tagName))]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
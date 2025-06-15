<?php

namespace App\Http\Controllers\admin\posts;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()
            ->with(['category', 'tags', 'user']) // eager load related models
            ->paginate(9); // customize the number of posts per page

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // File upload (optional)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        // Add user ID
        $validated['user_id'] = auth()->id();

        // Create Post
        $post = Post::create($validated);

        // Attach Tags
        $post->tags()->attach($validated['tags']);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['category', 'tags', 'user'])
            ->where('id', $id)
            ->firstOrFail();
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = Post::with(['category', 'tags', 'user'])
            ->where('id', $id)
            ->firstOrFail();
        abort_unless(Gate::allows('update-post', $post), 403);
        return view('posts.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // File upload (optional)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::findOrFail($id);
        abort_unless(Gate::allows('update-post', $post), 403);
        $post->update($validated);
        $post->tags()->sync($validated['tags']);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        abort_unless(Gate::allows('delete-post', $post), 403);
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}

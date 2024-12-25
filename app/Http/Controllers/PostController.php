<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
    return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
    
        $post = new Post($validated);
        $post->user_id = auth()->id();
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        return view('posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
    
        $post->update($validated);
    
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }
    
    public function destroy(Post $post)
    {
        // Ensure only the post owner can delete
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $post->delete();
    
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function search(Request $request)
{
    $query = $request->get('query');
    $posts = Post::where('title', 'like', "%{$query}%")->get();
    return response()->json($posts);
}
}

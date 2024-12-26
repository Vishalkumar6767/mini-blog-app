<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Post $post)
    {
        $comments = $post->comments()
            ->with('user')
            ->latest()
            ->paginate(2);  

        return [
            'comments' => $comments->items(),
            'has_more' => $comments->hasMorePages()
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

  
    public function store(Request $request, $postId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'exists:posts,id'
        ]);

        try {
            $comment = new Comment($validated);
            $comment->post_id = $postId;
            $comment->user_id = auth()->id();
            $comment->save();

            return response()->json([
                'comment' => $comment->load('user')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create comment'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $post = $request->filled('post')
            ? Post::find($request->query('post'))
            : null;

        $comments = Comment::with('post', 'user')
            ->when($post, fn ($q) => $q->where('post_id', $post->id))
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', compact('comments', 'post'));
    }


    
    /*
    REFACTORED: 
    OLD - Comment::create()	            User hidden input (post_id)
    NEW - $post->comments()->create()	    Your application (the $post)
    
    Explained:
    $comment = new Comment($attributes);
    $comment->setAttribute('post_id', $post->getKey());  // grabs FK from inferred parent
    $comment->save();
    
    So post_id is assigned in PHP, before the INSERT ever leaves your app. The database then checks it against the constraint. 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request, Post $post)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $isAdmin = $user->isAdmin();

        $post->comments()->create([
            'body'      => $validated['body'],
            'author'    => $user->name,
            'email'     => $user->email,
            'photo'     => $user->photo?->file,
            'is_active' => $isAdmin ? 1 : 0,
        ]);

        return back()->with('success', $isAdmin
            ? 'Comment posted.'
            : 'Your message has been submitted and is awaiting moderation.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::with(['post', 'replies'])->findOrFail($id);

        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 'sometimes' applies only if the field is present in the request!
        $validated = $request->validate([
            'is_active' => 'required|in:0,1',
            'author'    => 'sometimes|required|string|max:255',
            'email'     => 'sometimes|required|email|max:255',
            'body'      => 'sometimes|required|string|max:1000',
        ]);

        Comment::findOrFail($id)->update($validated);
        // back() preserves the ?post= filter when you approve from filtered index
        return redirect()->route('comments.index')->with('success', 'Comment updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return redirect()->back();
    }
}

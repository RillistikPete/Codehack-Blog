<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class PostCommentsController extends Controller
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

        $comments = Comment::with('post')
            ->when($post, fn ($q) => $q->where('post_id', $post->id))
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', compact('comments', 'post'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */


    /*
    REFACTORED: 
    OLD - Comment::create()	            User hidden input (post_id)
    NEW - $post->comments()->create()	    Your application (the $post)
    
    Explained:
    $comment = new Comment($attributes);
    $comment->setAttribute('post_id', $post->getKey());  // grabs FK from inferred parent
    $comment->save();

    So post_id is assigned in PHP, before the INSERT ever leaves your app. The database then checks it against the constraint. 
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

        return back()->with('comment_message', $isAdmin
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
        //
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
        // validate is_active so a crafted request can't rewrite a comment's body from the admin endpoint
        $validated = $request->validate([
            'is_active' => 'required|in:0,1',
        ]);
        Comment::findOrFail($id)->update($validated);
        return redirect()->back();
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

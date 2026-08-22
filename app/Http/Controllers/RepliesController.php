<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentReply;
use App\Models\Comment;
use App\Models\Post;


class CommentRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterComment = $request->filled('comment')
            ? Comment::with('post')->find($request->query('comment'))
            : null;

        $replies = CommentReply::with('comment.post')
            ->when($filterComment, fn ($q) => $q->where('comment_id', $filterComment->id))
            ->latest()
            ->paginate(20);

        return view('admin.replies.index', compact('replies', 'filterComment'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Comment $comment)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $isAdmin = $user->isAdmin();

        $comment->replies()->create([
            'body'      => $validated['body'],
            'author'    => $user->name,
            'email'     => $user->email,
            'photo'     => $user->photo?->file,
            'is_active' => $isAdmin ? 1 : 0,
        ]);

        return back()->with('success', $isAdmin
            ? 'Reply posted.'
            : 'Your reply has been submitted and is awaiting moderation.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reply = CommentReply::with('comment.post')->findOrFail($id);

        return view('admin.replies.edit', compact('reply'));
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
        // CommentReply::findOrFail($id)->update($request->all());
        // $request->all() lets a crafted request rewrite the author, email,
        //  or body from what's meant to be an approve/disapprove button
        $validated = $request->validate([
            'is_active' => 'required|in:0,1',
            'author'    => 'sometimes|required|string|max:255',
            'email'     => 'sometimes|required|email|max:255',
            'body'      => 'sometimes|required|string|max:1000',
        ]);

        CommentReply::findOrFail($id)->update($validated);

        return back();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CommentReply::findOrFail($id)->delete();
        
        return redirect()->back();

    }
}

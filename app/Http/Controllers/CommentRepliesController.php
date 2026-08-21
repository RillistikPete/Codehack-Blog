<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentReply;
use App\Models\Comment;


class CommentRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Comment $comment)
    {
                dd('req', $request);

        dd('comment', $comment);
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
        dd('comment', $comment);

        return back()->with('reply_message', $isAdmin
            ? 'Reply posted.'
            : 'Your reply has been submitted and is awaiting moderation.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        $replies = $comment->replies;
        return view('admin.comments.replies.show', compact('replies'));
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
        // CommentReply::findOrFail($id)->update($request->all());
        // $request->all() lets a crafted request rewrite the author, email,
        //  or body from what's meant to be an approve/disapprove button
        $validated = $request->validate([
            'is_active' => 'required|in:0,1',
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

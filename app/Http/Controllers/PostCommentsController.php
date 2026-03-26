<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Post;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $comments = Comment::all();

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    /* OLD FUNCTION:
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $data = [
            'post_id' => $request->post_id,
            'author' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo ? $user->photo->file : '',
            'body' => $request->body
        ];
        
        Comment::create($data);
        //return dd($data);
        
        $request->session()->flash('comment_message', 'Your message has been submitted and is awaiting moderation');
        return redirect()->back();
    }
    */


    // REFACTORED:
    //OLD - Comment::create()	            User hidden input (post_id)
    //NEW - $post->comments()->create()	    Your application (the $post)
    public function store(Request $request, Post $post)
    {
        $user = auth()->user();

        // Validate form (home blade)
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string|max:1000',
        ]);

        // merge validated + server-side fields
        $data = array_merge($validated, [
            'author' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo ? $user->photo->file : null,
        ]);

        Comment::create($data);

        return back()->with(
            'comment_message',
            'Your message has been submitted and is awaiting moderation.'
        );
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments;
        return view('admin.comments.show', compact('comments'));
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
        Comment::findOrFail($id)->update($request->all());
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

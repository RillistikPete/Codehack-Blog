<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\PostsCreateRequest;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
        //with('photo') so it doesn't fire a query for every post without an obj_url
        $posts = Post::with('photo')->orderBy('created_at', 'desc')->paginate(9);
        return view('admin.posts.index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(PostsCreateRequest $request): RedirectResponse
    {
        $input = $request->validated();
        $user = Auth::user();

        if ($file = $request->file('photo_id')) {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();

            $file->storeAs('', $name, 's3', 'public');

            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }

        $user->posts()->create($input);
        
        return redirect()->route('posts.index')->with('success', 'Post created.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     */
    public function edit($id): View
    {
        $post = Post::findOrFail($id);
        //had to add pluck for both post and categories in edit posts - edit.blade.php
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(PostsCreateRequest $request, $id): RedirectResponse
    {
        $post  = Post::findOrFail($id);
        $input = $request->validated();

        // capture the current photo before we point the post at a new one
        $oldPhoto = $post->photo;

        if ($file = $request->file('photo_id')) {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();

            $file->storeAs('', $name, 's3', 'public');

            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
            $input['obj_url']  = null;   // let the accessor re-derive
        }

        $post->update($input);

        // only now that the post points elsewhere is the old photo safe to remove
        if ($oldPhoto && $oldPhoto->id !== $post->photo_id) {
            Storage::disk('s3')->delete($oldPhoto->file);
            $oldPhoto->delete();
        }

        return redirect()->route('posts.index')->with('success', 'Post updated.');
    }

    /** 
     * Remove the specified resource from storage.
     * @param  int  $id
     */
    public function destroy($id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        
        // unlink(public_path() . $post->photo->file);
        $post->delete();

        return redirect()->route('posts.index');
    }
}

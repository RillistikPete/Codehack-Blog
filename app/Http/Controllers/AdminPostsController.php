<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\PostsCreateRequest;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
// for AdminPostsController@post to be able to find by slug
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // $posts = Post::all();
        $posts = Post::orderBy('created_at', 'desc')->paginate(9);
        return view('admin.posts.index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        if ($file = $request->file('photo_id')) {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();

            $file->storeAs('', $name, 's3');

            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }

        $user->posts()->create($input);
        
        return redirect()->route('posts.index')->with('success', 'Post created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        // delete post objurl so that it will update after refresh!
        // checking to see if photo exists, if not, create it:
        if ($file = $request->file('photo_id')) {
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();

            $file->storeAs('', $name, 's3');

            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }

        Auth::user()->posts()->whereId($id)->first()->update($input);

        return redirect('/admin/posts');
        
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // unlink(public_path() . $post->photo->file);
        $post->delete();

        return redirect('/admin/posts');
    }

    //this is for post.blade.php
    // removed after refactoring routes to call home controller instead
    // public function post($slug){

    //     $post = Post::findBySlug($slug);

    //     $comments = $post->comments()->whereIsActive(1)->get();
        
    //     return view('post', compact('post', 'comments'));

    // }



}

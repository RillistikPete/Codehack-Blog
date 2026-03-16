<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Photo;
use Illuminate\Support\Facades\Auth;
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
        $input = $request->all();
        $user = Auth::user();

        //Need to upload to S3 bucket instead of moving to image folder
        //******* MAY HELP FOR SPEC CHAR PROBLEM */ / 8-9-22
        //You might want to use Laravel's built-in Str::slug() method to convert that title into something friendlier
        if($file = $request->file('photo_id')) {
            // If you have file, get the original name of it,
            // then move it to the images folder,
            // then create a photo, then in 'Create Post', insert photo id
            $name = str_replace(' ', '-', $file->getClientOriginalName());
            // $finalName = str_replace('#', '')
            // $file->move('images', $name);
            $file->store($name, 's3');
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }

        $user->posts()->create($input);
        
        return redirect('/admin/posts');
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
        if($file = $request->file('photo_id')) {
            $name = str_replace(' ', '-', $file->getClientOriginalName());
            // $file->move('images', $name);
            $file->store($name, 's3');
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        //see same logic in @store, we are eliminating lines
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
    public function post($slug){

        $post = Post::findBySlug($slug);

        $comments = $post->comments()->whereIsActive(1)->get();
        
        return view('post', compact('post', 'comments'));

    }



}

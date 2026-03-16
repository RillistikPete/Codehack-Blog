<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Http\Request;
use App\Post;
use App\Photo;
use App\Comment;
use App\Category;
use Carbon\Carbon;
use Auth;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-2'
        ]);
        $bucket = 'codehack-heroku-photos';
        $iterator = $s3Client->getIterator('ListObjects', array(
            'Bucket' => $bucket
        ));
        $arrayS3PicKeys = array();
        foreach ($iterator as $obj){
            array_push($arrayS3PicKeys, $obj['Key']);
        }
        $s3ObjectsUrlArray = array();
        foreach ($arrayS3PicKeys as $key) {
            $url = $s3Client->getObjectUrl($bucket, $key);
            array_push($s3ObjectsUrlArray, $url);
        }
        //=================================================
        $user = Auth::user();
        $posts = Post::orderBy('created_at', 'desc')->paginate(9);
        foreach($posts as $post){
            foreach ($s3ObjectsUrlArray as $objUrl) {
                if($post->photo->file){
                    if (str_contains($objUrl, substr($post->photo->file, 8))) {
                        $post->obj_url = $objUrl;
                        // echo "<script>console.log('post->obj_url - " . $post->obj_url . "photo" . $post->photo->file . "');</script>";
                    }
                }
            }
        }
        $postComments = Post::with('comments')->orderBy('created_at', 'desc')->get();
        $comments = Comment::all();
        $categories = Category::all();

        return view('front/home', compact('posts', 'user', 'comments', 'categories', 'postComments', 'arrayS3PicKeys', 's3ObjectsUrlArray'));
        //if you wish, you may pass an array of data as the second parameter given to the make method:
        //$view = View::make('greetings', $data);
    }

    // post.blade.php
    public function post($slug){

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-2'
        ]);
        $bucket = 'codehack-heroku-photos';
        $iterator = $s3Client->getIterator('ListObjects', array(
            'Bucket' => $bucket
        ));
        $arrayS3PicKeys = array();
        foreach ($iterator as $obj){
            array_push($arrayS3PicKeys, $obj['Key']);
        }
        $s3ObjectsUrlArray = array();
        foreach ($arrayS3PicKeys as $key) {
            $url = $s3Client->getObjectUrl($bucket, $key);
            array_push($s3ObjectsUrlArray, $url);
        }
        //=================================================
        $user = Auth::user();
        $post = Post::findBySlug($slug);
        $replacedHashtag = 'dummydatavar';
        echo "<script>console.log('post photo file " . $post->photo->file . "')</script>";
        if (str_contains($post->photo->file, '#')) {
            $replacedHashtag = str_replace('#', '%23', $post->photo->file);
            echo "<script>console.log('replacing filename hashtag " . $replacedHashtag . "')</script>";
        }
        if(!$post->obj_url && $post->photo->file) {
            echo "<script>console.log('objurl doesnt exist, reload page')</script>";
            foreach($s3ObjectsUrlArray as $obj_url){
                if (str_contains($obj_url, substr($post->photo->file, 8)) || str_contains($obj_url, substr($replacedHashtag, 8))) {
                    $post->obj_url = $obj_url;
                    $post->save();
                }
            }
        }
        else {
            echo "<script>console.log('objurl exists')</script>";
        }
        $categories = Category::all();
        $comments = $post->comments()->whereIsActive(1)->get();
        
        return view('post', compact('post', 'comments', 'categories', 'user'));
    }

    public function categPosts($id){

        $user = Auth::user();
        $category = Category::with('posts')->orderBy('name', 'asc');
        $categories = Category::all();
        $posts = Post::where('category_id', '=', $id)
        ? Post::where('category_id', '=', $id)->orderBy('created_at', 'desc')->paginate(5)
        : null;
        if ($posts->total() === 0) {
            abort(400);
        }
        // $posts = $categories->paginate(10);
        return view('front/categ-posts', compact('posts', 'categories', 'category', 'user', 'arrayS3PicKeys', 's3ObjectsUrlArray'));
    }
}

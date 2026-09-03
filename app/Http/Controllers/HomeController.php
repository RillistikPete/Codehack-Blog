<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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
     */
    public function index()
    {
        return view('front/home', [
            'posts' => Post::with(['category', 'photo'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(9),
            'category'   => null,
            'categories' => Category::all(),
        ]);
    }

    public function post($slug)
    {
        $post = Post::with('photo')->where('slug', $slug)->firstOrFail();

        return view('post', [
            'post'       => $post,
            'comments'   => $post->comments()->with('replies')->where('is_active', 1)->get(), //eager load replies
            'categories' => Category::all(),
            'user'       => Auth::user(),
        ]);
    }

    public function categPosts($id)
    {
        $category = Category::findOrFail($id);

        return view('front/home', [
            'posts' => Post::with(['category', 'photo'])
                        ->where('category_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(9),
            'category'   => $category,
            'categories' => Category::all(),
        ]);
    }
}

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
            'posts' => Post::with(['photo', 'category', 'comments.replies'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(9),
            'user'       => Auth::user(),
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

        return view('front/categ-posts', [
            'posts'      => Post::with('photo')
                                ->where('category_id', $id)
                                ->orderBy('created_at', 'desc')
                                ->paginate(5),
            'categories' => Category::all(),
            'category'   => $category,
            'user'       => Auth::user(),
        ]);
    }
}

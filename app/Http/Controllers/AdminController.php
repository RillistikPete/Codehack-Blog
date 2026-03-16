<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Comment;

class AdminController extends Controller
{
    public function index() {

        $postCount = Post::count();
        $categoryCount = Category::count();
        $commentCount = Comment::count();

        return view('admin/index', compact('postCount', 'categoryCount', 'commentCount'));
    }
}

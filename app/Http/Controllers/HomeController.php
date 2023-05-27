<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $friend_posts = Post::whereIn("user_id", Auth::user()->friends->pluck('id')->toArray())->orderBy("created_at", "desc")->get();
            $new_posts = Post::latest("created_at")->orderBy('created_at', "desc")->limit(50)->get();
            $group_posts = Post::whereIn("group_id", Auth::user()->groups->pluck("id")->toArray())->orderBy('created_at', "desc")->get();
            $posts = $friend_posts->merge($new_posts)->merge($group_posts)->shuffle();

            return view('home', compact("posts"));
        } else {
            return view("welcome");
        }
    }
}

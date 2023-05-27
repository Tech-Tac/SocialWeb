<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->q;
        $users = User::where("name", "like", "%" . $query . "%")->get();
        $groups = Group::where("name", "like", "%" . $query . "%")->orWhere("description", "like", "%" . $query . "%")->get();
        $posts = Post::where("title", "like", "%" . $query . "%")->orWhere('content', 'like', "%" . $query . "%")->orWhereIn("user_id", $users->pluck('id')->toArray())->orWhereIn("group_id", $groups->pluck('id')->toArray())->get();
        return view("search", compact('users', 'groups', 'posts'));
    }
}

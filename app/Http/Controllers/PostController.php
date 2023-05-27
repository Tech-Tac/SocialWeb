<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Add a like to a post.
     */
    public function like(Post $post)
    {
        $like = Like::where(["user_id" => Auth::user()->id, "post_id" => $post->id])->first();
        if ($like) {
            $like->delete();
        } else {
            Like::create(["user_id" => Auth::user()->id, "post_id" => $post->id]);
        }
        return $post->likes->count();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:2047',
        ]);

        if (!$request->group || ($request->group && in_array($request->group, Auth::user()->groups->pluck("id")->toArray()))) {
            Post::create([
                'user_id' => Auth::user()->id,
                'group_id' => $request->group,
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        Session::flash("message", "Post created succesfully!");

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        Session::flash("message", "Post deleted succesfully!");
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validate([
            'content' => 'required|max:2047',
            'post_id' => 'required|exists:posts,id',
            'comment_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request->post_id,
            'comment_id' => $request->comment_id,
            'content' => $request->content,
        ]);
        /* Session::flash("message", "Comment sent succesfully!");
        Session::flash("alert-type", "success");
        return redirect()->back()->withFragment('#post_' . $comment->post->id); */
        return view("partials.comment", compact("comment"));
    }

    /**
     * Add a like to a post.
     */
    public function like(Comment $comment)
    {
        $like = Like::where(["user_id" => Auth::user()->id, "comment_id" => $comment->id])->first();
        if ($like) {
            $like->delete();
        } else {
            Like::create(["user_id" => Auth::user()->id, "comment_id" => $comment->id]);
        }
        return $comment->likes->count();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return redirect(route("posts.show", $comment->post))->withFragment("comment_" . $comment->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|max:2047',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        Session::flash("message", "Comment deleted succesfully!");
        Session::flash("alert-type", "success");
        return redirect()->back();
    }
}

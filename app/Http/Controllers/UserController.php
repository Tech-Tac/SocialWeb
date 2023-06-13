<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Friendship;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("users.index", compact("users"));
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view("users.show", compact("user"));
    }

    /**
     * add friend
     */
    public function addFriend(User $user)
    {
        if ($this->sendRequest($user)) {
            Session::flash("message", "Request sent!");
            Session::flash("alert-type", "success");
        } elseif ($this->acceptRequest($user)) {
            Session::flash("message", "You are now friends!");
            Session::flash("alert-type", "success");
        } elseif ($this->removeFriend($user)) {
            Session::flash("message", "Removed friend!");
            Session::flash("alert-type", "success");
        }

        return redirect()->back();
    }

    public function sendRequest(User $user)
    {
        if (Friendship::where(["from_id" => Auth::user()->id, "to_id" => $user->id])->orWhere(["from_id" => $user->id, "to_id" => Auth::user()->id])->count() === 0) {
            Friendship::create([
                "from_id" => Auth::user()->id,
                "to_id" => $user->id,
            ]);
            return true;
        }
        return false;
    }

    public function acceptRequest(User $user)
    {
        $request = Friendship::where(["from_id" => $user->id, "to_id" => Auth::user()->id, "status" => "pending"])->first();
        if ($request) {
            $request->update([
                'status' => "approved"
            ]);
            return true;
        }
        return false;
    }

    public function removeFriend(User $user)
    {
        $friendship = Friendship::where(["from_id" => Auth::user()->id, "to_id" => $user->id])->orWhere(["from_id" => $user->id, "to_id" => Auth::user()->id])->first();
        if ($friendship) {
            $friendship->delete();
            return true;
        }
        return false;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        return view("users.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            "name" => "required|max:255",
            "email" => "required|max:255|unique:users,email," . Auth::user()->id,
            "about" => "nullable|max:1023",
            "avatar" => "nullable|image",
            "old_password" => "nullable|max:255|current_password",
            "password" => "required_with:old_password|max:255|confirmed",
            "password_confirmation" => "required_with:password|max:255",
        ]);

        User::whereId(Auth::user()->id)->update([
            "name" => $request->name,
            "about" => $request->about,
        ]);

        if ($request->password) {
            User::whereId(Auth::user()->id)->update([
                "password" => Hash::make($request->password),
            ]);
        }

        if ($request->avatar) {
            $image_name = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images'), $image_name);

            User::whereId(Auth::user()->id)->update([
                "avatar" => $image_name,
            ]);
        }

        Session::flash("message", "Account updated successfully!");
        Session::flash("alert-type", "success");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        User::whereId(Auth::user()->id)->delete();
        Auth::logout();
        Session::flash("message", "Account deleted successfully, sad to see you go.");
        Session::flash("alert-type", "info");
        return redirect(route("home"));
    }
}

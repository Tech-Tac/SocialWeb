<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::orderBy("created_at", "desc")->get();
        return view("groups.index", compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("groups.form");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $validated = $request->validate([
            "name" => "required|max:255",
            "description" => "max:1023",
            "icon" => "nullable|image",
        ]);

        $image_name = null;

        if ($request->icon) {
            $image_name = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('images'), $image_name);
        }

        $group = Group::create([
            "name" => $request->name,
            "description" => $request->description,
            "icon" => $image_name,
        ]);

        $this->join($group);

        Session::flash("message", "Group created successfully!");
        Session::flash("alert-type", "success");
        return redirect(route('groups.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return view("groups.show", compact("group"));
    }

    /**
     * Add the current logged in user to the group.
     */
    public function join(Group $group)
    {
        if (Membership::where(["group_id" => $group->id, "user_id" => Auth::user()->id])->count() === 0) {
            Membership::create(["group_id" => $group->id, "user_id" => Auth::user()->id]);
            Session::flash("message", "Joined group successfully!");
            Session::flash("alert-type", "success");
        } else {
            Session::flash("message", "Already joined.");
            Session::flash("alert-type", "info");
        }
        return redirect()->back();
    }
    /**
     * Exit the current logged in user from the group.
     */
    public function leave(Group $group)
    {
        $membership = Membership::where(["group_id" => $group->id, "user_id" => Auth::user()->id])->first();
        if ($membership) {
            $membership->delete();
            Session::flash("message", "Left group successfully!");
            Session::flash("alert-type", "success");
        } else {
            Session::flash("message", "You are not a member of this group");
            Session::flash("alert-type", "info");
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return view("groups.form", compact("group"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $validated = $request->validate([
            "name" => "required|max:255",
            "description" => "max:1023",
            "icon" => "nullable|image",
        ]);

        $group->update([
            "name" => $request->name,
            "description" => $request->description,
        ]);

        if ($request->icon && $request->clear_icon == 0) {
            $image_name = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('images'), $image_name);

            $group->update([
                "icon" => $image_name,
            ]);
        } elseif ($request->clear_icon == 1) {
            $group->update([
                "icon" => null,
            ]);
        }

        Session::flash('message', 'Group updated successfully!');
        Session::flash("alert-type", "success");
        return redirect(route('groups.show', $group));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        Session::flash('message', 'Group deleted successfully!');
        Session::flash("alert-type", "success");
        return redirect()->back();
    }
}

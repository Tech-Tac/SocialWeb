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
        $groups = Group::all();
        return view("groups.index", compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("groups.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $validated = $request->validate([
            "name" => "required|max:255",
            "description" => "max:1023",
        ]);

        Group::create([
            "name" => $request->name,
            "description" => $request->description,
        ]);

        Session::flash("message", "Group created succesfully!");
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
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        Session::flash('message', 'Group deleted successfully');
        return redirect()->back();
    }
}

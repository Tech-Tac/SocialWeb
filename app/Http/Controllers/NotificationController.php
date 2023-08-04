<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::where("user_id", Auth::user()->id)->orderBy("created_at", "desc")->get();
        return view("notifications", compact("notifications"));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function markAsRead(Request $request)
{
    auth()->user()
        ->unreadNotifications
        ->when($request->input('id'), function ($query) use ($request) { //if there is an id given, process that one, if not, do all
            return $query->where('id', $request->input('id')); 
        })
        ->markAsRead();

    return response()->noContent();
}
}

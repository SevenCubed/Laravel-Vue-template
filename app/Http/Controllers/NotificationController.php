<?php

namespace App\Http\Controllers;

use App\Events\AdBidEvent;
use App\Models\Bid;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['test']]);
    }

    public function notifications()
    {
        $notifications = auth()->user()->unreadNotifications;
        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
    auth()->user()
        ->unreadNotifications
        ->where('id', $id) 
        ->markAsRead();

    return response()->noContent();
    }
    public function markAllAsRead(Request $request)
    {
    auth()->user()
        ->unreadNotifications
        ->markAsRead();
    return response()->noContent();
    }
    public function test()
    {
        $bid = Bid::find(10);
        $payload = [$bid->product, $bid->product->user, $bid->amount, $bid->user->name];
        AdBidEvent::dispatch($payload);
    }
    
}

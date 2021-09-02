<?php

namespace App\Listeners;

use App\Events\AdBidEvent;
use App\Models\User;
use App\Notifications\AdBidNotification;
use App\Notifications\TestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAdBidNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  AdBidEvent  $event
     * @return void
     */
    public function handle(AdBidEvent $event)
    {
        $product = $event->payload[0];
        $seller = $event->payload[1];
        $amount = $event->payload[2];
        $buyerName = $event->payload[3];
        $seller->notify(new AdBidNotification($product, $amount, $buyerName));
        $admins = User::find(51);
        $admins->notify(new TestNotification($product, $amount, $buyerName));
    }
}

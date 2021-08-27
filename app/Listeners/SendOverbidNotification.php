<?php

namespace App\Listeners;

use App\Events\OverbidEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use App\Mail\OverbidNotification;
use Illuminate\Support\Facades\Mail;


class SendOverbidNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OverbidEvent  $event
     * @return void
     */
    public function handle(OverbidEvent $event)
    {
        foreach($event->lowerBids as $bid){
            //get the user emails for each user_id within the bids - whereIn
        }
        foreach($recipients as $recipient){
            Mail::to($recipient->email)->send(new OverbidNotification());
        }
    }
}

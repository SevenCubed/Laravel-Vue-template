<?php

namespace App\Listeners;

use App\Events\OverbidEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use App\Mail\OverbidNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class SendOverbidNotification implements ShouldQueue
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
        $recipients = User::whereIn('id', $event->lowerBids)
        //->whereIn('notifications', true) - Not building this in yet because I'll have to remigrate and it'll be a pain to test, but leaving this here just as proof of concept
        ->get();
        foreach($recipients as $recipient){
            Mail::to($recipient->email)->send(new OverbidNotification());
            //using a Notification is probably cleaner and easier, but I've already refactored the Ad Bid event as proof of concept for this.
        }
    }
}

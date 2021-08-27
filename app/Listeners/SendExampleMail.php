<?php

namespace App\Listeners;

use App\Events\ExampleMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;

class SendExampleMail implements ShouldQueue
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
     * @param  ExampleMail  $event
     * @return void
     */
    public function handle(ExampleMail $event)
    {
        $recipient = User::find(51);
        Mail::to($recipient->email)->send(new MailtrapExample());
    }
}

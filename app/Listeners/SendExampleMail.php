<?php

namespace App\Listeners;

use App\Events\ExampleMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendExampleMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Handle the event.
     *
     * @param  ExampleMail  $event
     * @return void
     */
    public function handle(ExampleMail $event)
    {
        $recipients = User::all(); 
        foreach($recipients as $recipient){
            Mail::to($recipient->email)->send(new MailtrapExample($recipient));
        }
    }
}

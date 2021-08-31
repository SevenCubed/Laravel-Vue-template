<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class AdBidNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('/#/products/');
        return (new MailMessage)
            ->greeting('Hello')
            ->line('Someone has placed a new bid on your ad!')
            ->action('View Product', $url)
            ->line('Remember we do not have chat functionality, so good luck contacting them!');
    }
}

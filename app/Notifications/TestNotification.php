<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product, $amount, $buyerName)
    {
        $this->product = $product;
        $this->amount = $amount;
        $this->buyerName = $buyerName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $i = rand(0,3);
        switch ($i) {
            case 0:
                $type = 'is-primary';
                break;
            case 1:
                $type = 'is-info';
                break;
            case 2:
                $type = 'is-warning';
                break;
            case 3:
                $type = 'is-danger';
                break;
        }
        return [
            'message' => "{$this->buyerName} has made a bid of €{$this->amount} on {$this->product->name} offered by {$this->product->user->name}",
            'type' => $type
        ];
    }
}

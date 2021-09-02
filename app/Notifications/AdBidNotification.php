<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdBidNotification extends Notification
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = 'localhost:8000/#/products/'.$this->product->id; //url('/#/products/') neemt de :8000 niet mee;
        return (new MailMessage())
            ->greeting('Hi there')
            ->line("{$this->buyerName} has placed a bid of €{$this->amount} on your ad for {$this->product->name}!")
            ->action('View Product', $url)
            ->line('Remember we do not have chat functionality yet (soon), so good luck contacting them!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            // 'buyerName' => $this->buyerName,
            // 'amount' => $this->amount,
            // 'seller' => $this->seller,
            // 'productName' => $this->product->name,
            // 'productID' => $this->product->id,
        ];
    }
    /**     
    *
    * @param  mixed  $notifiable
    * @return array
    */
   public function toDatabase($notifiable)
   {
       return [
           'payload' => $this->product,
           'amount' => $this->amount,
           'type' => "is-primary",
       ];
   }
}

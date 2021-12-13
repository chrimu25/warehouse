<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientRequestNotification extends Notification
{
    use Queueable;
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
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

    public function toArray($notifiable)
    {
        return [
            'title'=>'New '.$this->product->item->name.' Storage Request',
            'user'=>$this->product->owner->name,
            'data'=>'Request to store'.$this->product->item->name.' '.$this->product->quantity.$this->product->unity->name.' in '.$this->product->slot->name,
        ];
    }
}

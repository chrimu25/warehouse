<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferRequestNotification extends Notification
{
    use Queueable;

    public $transfer;

    public function __construct($transfer)
    {
        $this->transfer = $transfer;
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
            'title'=>'Transfer Request',
            'user'=>$this->transfer->owner1->name,
            'data'=>'Request to transfer '.$this->transfer->product->item->name.' '.$this->transfer->quantity.$this->transfer->unity->name.' to '.$this->transfer->toWarehouse->name,
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrasnsferRequestDenied extends Notification
{
    use Queueable;
    public $transfer;

    public function __construct($transfer)
    {
        $this->transfer = $transfer;
    }

    public function via($notifiable)
    {
        return ['database','mail'];
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
        ->line('Your Request to transfer '.$this->transfer->quantity.$this->transfer->unity->name.' of '.$this->transfer->product->item->name)
        ->line('Requested on'.$this->transfer->created_at.' Denied!');
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
            'name'=>'Transfer Request',
            'message'=>'Request to transfer '.$this->transfer->quantity.$this->transfer->unity->name.' of '.$this->transfer->product->item->name.' Denied!',
        ];
    }
}

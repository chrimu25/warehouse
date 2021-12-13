<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrasnsferRequestApproved extends Notification
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

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->line('Your Request to transfer '.$this->transfer->quantity.$this->transfer->unity->name.' of '.$this->transfer->product->item->name)
        ->line('Requested on'.$this->transfer->created_at.' Approved!')
        ->line('Your Item(s) are now stored in '.$this->transfer->toWarehouse->name.' in '.$this->transfer->slot->name.' Slot')
        ->line('Daily Fees is '.$this->transfer->slot->price.'Rwf/Day from '.$this->transfer->created_at." Until".$this->transfer->until)
        ;
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
            'message'=>'Request to transfer '.$this->transfer->quantity.$this->transfer->unity->name.' of '.$this->transfer->product->item->name.' Approved!',
        ];
    }
}

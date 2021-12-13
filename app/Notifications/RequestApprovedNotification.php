<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestApprovedNotification extends Notification
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
                    ->line('Your Request of '.$this->product->created_at.' Approved!')
                    ->line('Your Item(s) are being stored in '.$this->product->warehouse->name.' in '.$this->product->slot->name.' Slot')
                    ->line('Daily Fees is '.$this->product->slot->price.'Rwf/Day from '.$this->product->created_at." Until".$this->product->until)
                    // ->action('Notification Action', url('/'))
                    ->line('Each day count! Be awera');
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
            'name'=>'Storage Space Request',
            'message'=>'Your Request of '.$this->product->quantity.$this->product->unity->name.' of '.$this->product->item->name.' at '.$this->product->created_at.' Approved!',
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvoiceNotification extends Notification
{
    use Queueable;

    public $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

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
                    ->line(config('app.name'). 'Invoice')
                    ->line($this->invoice->code. ' created at '.$this->invoice->created_at)
                    ->line('Slot: '.$this->invoice->product->slot->name)
                    ->line('Price/Day: '.$this->invoice->product->slot->price)
                    ->line('Total Days: '.$this->invoice->days)
                    ->line('Total Price: '.$this->invoice->total_price);
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
            'title'=>'You have new invoice, '.$this->invoice->code,
        ];
    }
}

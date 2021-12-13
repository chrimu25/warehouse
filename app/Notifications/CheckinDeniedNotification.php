<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckinDeniedNotification extends Notification
{
    use Queueable;
    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function via($notifiable)
    {
        return ['database','mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your checkin request of '.$this->activity->quantity.' on '.$this->activity->created_at.' Denied!');
    }

    public function toArray($notifiable)
    {
        return [
            'name'=>'Checkin Request',
            'message'=>'Your checkin request of '.$this->activity->quantity.' on '.$this->activity->created_at.' Denied!',
        ];
    }
}

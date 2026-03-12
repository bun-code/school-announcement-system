<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionConfirm extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirm your subscription')
            ->greeting('Hello!')
            ->line('Please confirm your email subscription to receive announcements and event updates.')
            ->action('Confirm Subscription', route('subscribe.confirm', $notifiable->token))
            ->line('If you did not request this, you can ignore this email.');
    }
}

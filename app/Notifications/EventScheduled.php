<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventScheduled extends Notification
{
    use Queueable;

    public function __construct(private Event $event)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $date = $this->event->event_date?->format('M j, Y') ?? 'Date TBA';
        $start = $this->event->start_time ? \Carbon\Carbon::parse($this->event->start_time)->format('g:i A') : null;
        $end = $this->event->end_time ? \Carbon\Carbon::parse($this->event->end_time)->format('g:i A') : null;
        $time = $start ? $start : 'Time TBA';
        if ($start && $end) {
            $time = $start . ' - ' . $end;
        }

        $location = $this->event->location ?? 'Location TBA';

        return (new MailMessage)
            ->subject('Upcoming Event: ' . $this->event->title)
            ->greeting('Hello!')
            ->line('A new event has been scheduled.')
            ->line($this->event->title)
            ->line($date . ' at ' . $time)
            ->line($location)
            ->action('View Calendar', url('/events'))
            ->line('You can unsubscribe anytime using the link below.')
            ->action('Unsubscribe', route('subscribe.unsubscribe', $notifiable->token));
    }
}

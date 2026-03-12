<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class EventsTodayDigest extends Notification
{
    use Queueable;

    public function __construct(private Collection $events)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Events Happening Today')
            ->greeting('Good day!')
            ->line('Here are the school events happening today:')
            ->line('');

        foreach ($this->events as $event) {
            $date = $event->event_date?->format('M j, Y') ?? '';
            $start = $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('g:i A') : null;
            $end = $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('g:i A') : null;
            $time = $start ? $start : 'Time TBA';
            if ($start && $end) {
                $time = $start . ' - ' . $end;
            }
            $location = $event->location ?? 'Location TBA';

            $mail->line('• ' . $event->title . ' — ' . $date . ' at ' . $time . ' — ' . $location);
        }

        return $mail
            ->line('')
            ->action('View Calendar', url('/events'))
            ->line('You can unsubscribe anytime using the link below.')
            ->action('Unsubscribe', route('subscribe.unsubscribe', $notifiable->token));
    }
}

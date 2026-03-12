<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementPublished extends Notification
{
    use Queueable;

    public function __construct(private Announcement $announcement)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $link = url('/announcements#announcement-' . $this->announcement->id);

        return (new MailMessage)
            ->subject('New Announcement: ' . $this->announcement->title)
            ->greeting('Hello!')
            ->line('A new announcement has been published on Taboc Elementary School.')
            ->line($this->announcement->title)
            ->action('Read Announcement', $link)
            ->line('You can unsubscribe anytime using the link below.')
            ->action('Unsubscribe', route('subscribe.unsubscribe', $notifiable->token));
    }
}

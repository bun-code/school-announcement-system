<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Subscriber;
use App\Notifications\EventReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEventReminders extends Command
{
    protected $signature = 'notify:events-reminder';
    protected $description = 'Send email reminders for events happening tomorrow';

    public function handle(): int
    {
        $tomorrowEvents = Event::query()
            ->whereDate('event_date', today()->addDay())
            ->where(function ($q) {
                $q->whereNull('status')
                  ->orWhere('status', '!=', 'cancelled');
            })
            ->orderBy('event_date')
            ->get();

        if ($tomorrowEvents->isEmpty()) {
            $this->info('No events for tomorrow.');
            return self::SUCCESS;
        }

        $subscribers = Subscriber::eligibleForEventReminders()
            ->where(function ($q) {
                $q->whereNull('last_event_reminder_on')
                  ->orWhereDate('last_event_reminder_on', '!=', today());
            })
            ->get();

        if ($subscribers->isEmpty()) {
            $this->info('No subscribers to notify for reminders.');
            return self::SUCCESS;
        }

        foreach ($tomorrowEvents as $event) {
            Notification::send($subscribers, new EventReminder($event));
        }

        Subscriber::whereIn('id', $subscribers->pluck('id'))
            ->update(['last_event_reminder_on' => today()]);

        $this->info('Event reminders sent.');
        return self::SUCCESS;
    }
}

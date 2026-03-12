<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Subscriber;
use App\Notifications\EventsTodayDigest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEventsTodayNotifications extends Command
{
    protected $signature = 'notify:events-today';
    protected $description = 'Send email notifications for events happening today';

    public function handle(): int
    {
        $todayEvents = Event::query()
            ->whereDate('event_date', today())
            ->where(function ($q) {
                $q->whereNull('status')
                  ->orWhere('status', '!=', 'cancelled');
            })
            ->orderBy('event_date')
            ->get();

        if ($todayEvents->isEmpty()) {
            $this->info('No events today.');
            return self::SUCCESS;
        }

        $subscribers = Subscriber::eligibleForEvents()
            ->where(function ($q) {
                $q->whereNull('last_event_digest_on')
                  ->orWhereDate('last_event_digest_on', '!=', today());
            })
            ->get();

        if ($subscribers->isEmpty()) {
            $this->info('No active subscribers to notify.');
            return self::SUCCESS;
        }

        Notification::send($subscribers, new EventsTodayDigest($todayEvents));

        Subscriber::whereIn('id', $subscribers->pluck('id'))
            ->update(['last_event_digest_on' => today()]);

        $this->info('Events today notifications sent.');
        return self::SUCCESS;
    }
}

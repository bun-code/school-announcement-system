<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Subscriber;
use App\Notifications\EventScheduled;
use Illuminate\Support\Facades\Notification;

class EventObserver
{
    public function created(Event $event): void
    {
        if ($event->status === 'cancelled') {
            return;
        }

        if (!$event->event_date || $event->event_date->lt(now()->startOfDay())) {
            return;
        }

        $subscribers = Subscriber::eligibleForEvents()->get();
        if ($subscribers->isEmpty()) {
            return;
        }

        Notification::send($subscribers, new EventScheduled($event));
    }
}

<?php

namespace App\Observers;

use App\Models\Announcement;
use App\Models\Subscriber;
use App\Notifications\AnnouncementPublished;
use Illuminate\Support\Facades\Notification;

class AnnouncementObserver
{
    public function saved(Announcement $announcement): void
    {
        if ($announcement->status !== 'published') {
            return;
        }

        $justPublished = $announcement->wasRecentlyCreated || $announcement->wasChanged('status');
        if (!$justPublished) {
            return;
        }

        $subscribers = Subscriber::eligibleForAnnouncements()->get();
        if ($subscribers->isEmpty()) {
            return;
        }

        Notification::send($subscribers, new AnnouncementPublished($announcement));
    }
}

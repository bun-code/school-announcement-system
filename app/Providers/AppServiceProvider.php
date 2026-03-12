<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Event;
use App\Observers\AnnouncementObserver;
use App\Observers\EventObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Announcement::observe(AnnouncementObserver::class);
        Event::observe(EventObserver::class);
    }
}

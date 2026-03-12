<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use Notifiable;

    protected $fillable = [
        'email',
        'token',
        'is_active',
        'confirmed_at',
        'notify_announcements',
        'notify_events',
        'notify_event_reminders',
        'unsubscribed_at',
        'last_event_digest_on',
        'last_event_reminder_on',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'unsubscribed_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'notify_announcements' => 'boolean',
        'notify_events' => 'boolean',
        'notify_event_reminders' => 'boolean',
        'last_event_digest_on' => 'date',
        'last_event_reminder_on' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeConfirmed($query)
    {
        return $query->whereNotNull('confirmed_at');
    }

    public function scopeEligibleForAnnouncements($query)
    {
        return $query->active()->confirmed()->where('notify_announcements', true);
    }

    public function scopeEligibleForEvents($query)
    {
        return $query->active()->confirmed()->where('notify_events', true);
    }

    public function scopeEligibleForEventReminders($query)
    {
        return $query->active()->confirmed()->where('notify_event_reminders', true);
    }
}

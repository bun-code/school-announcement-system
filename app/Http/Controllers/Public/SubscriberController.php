<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Notifications\SubscriptionConfirm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'notify_announcements' => ['nullable', 'boolean'],
            'notify_events' => ['nullable', 'boolean'],
            'notify_event_reminders' => ['nullable', 'boolean'],
        ]);

        $notifyAnnouncements = $request->has('notify_announcements')
            ? $request->boolean('notify_announcements')
            : true;
        $notifyEvents = $request->has('notify_events')
            ? $request->boolean('notify_events')
            : true;
        $notifyReminders = $request->has('notify_event_reminders')
            ? $request->boolean('notify_event_reminders')
            : false;

        if (!$notifyAnnouncements && !$notifyEvents) {
            return back()
                ->withErrors(['preferences' => 'Please select at least one update type.'])
                ->withInput();
        }

        if ($notifyReminders && !$notifyEvents) {
            $notifyEvents = true;
        }

        $subscriber = Subscriber::where('email', $data['email'])->first();

        if ($subscriber) {
            $subscriber->fill([
                'notify_announcements' => $notifyAnnouncements,
                'notify_events' => $notifyEvents,
                'notify_event_reminders' => $notifyReminders,
            ]);

            if ($subscriber->is_active && $subscriber->confirmed_at) {
                $subscriber->save();
                return back()->with('subscribe_success', 'Your subscription preferences were updated.');
            }

            $subscriber->token = Str::random(48);
            $subscriber->is_active = false;
            $subscriber->confirmed_at = null;
            $subscriber->unsubscribed_at = null;
            $subscriber->save();

            $subscriber->notify(new SubscriptionConfirm());

            return back()->with('subscribe_success', 'Please confirm your email. We sent you a confirmation link.');
        }

        $subscriber = Subscriber::create([
            'email' => $data['email'],
            'token' => Str::random(48),
            'is_active' => false,
            'confirmed_at' => null,
            'notify_announcements' => $notifyAnnouncements,
            'notify_events' => $notifyEvents,
            'notify_event_reminders' => $notifyReminders,
        ]);

        $subscriber->notify(new SubscriptionConfirm());

        return back()->with('subscribe_success', 'Please confirm your email. We sent you a confirmation link.');
    }

    public function confirm(string $token): RedirectResponse
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();

        $subscriber->update([
            'is_active' => true,
            'confirmed_at' => now(),
            'unsubscribed_at' => null,
        ]);

        return redirect('/')->with('subscribe_success', 'Subscription confirmed. You will now receive updates.');
    }

    public function unsubscribe(string $token): RedirectResponse
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();

        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        return redirect('/')->with('subscribe_success', 'You have been unsubscribed.');
    }
}

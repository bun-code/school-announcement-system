<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->timestamp('confirmed_at')->nullable()->after('token');
            $table->boolean('notify_announcements')->default(true)->after('confirmed_at');
            $table->boolean('notify_events')->default(true)->after('notify_announcements');
            $table->boolean('notify_event_reminders')->default(true)->after('notify_events');
            $table->date('last_event_reminder_on')->nullable()->after('last_event_digest_on');
        });
    }

    public function down(): void
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->dropColumn([
                'confirmed_at',
                'notify_announcements',
                'notify_events',
                'notify_event_reminders',
                'last_event_reminder_on',
            ]);
        });
    }
};

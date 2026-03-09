<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', [
                'Academic',
                'Sports',
                'Cultural',
                'Program',
                'Community',
                'Health',
            ])->default('Academic');
            $table->enum('status', [
                'upcoming',
                'scheduled',
                'completed',
                'cancelled',
            ])->default('upcoming');

            $table->date('event_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for calendar queries
            $table->index('event_date');
            $table->index('status');
            $table->index('category');
            $table->index(['event_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
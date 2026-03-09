<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->nullable()->unique();
            $table->string('phone', 20)->nullable();

            $table->string('position')->nullable();     // e.g. 'Master Teacher I'
            $table->enum('type', [
                'teaching',
                'non-teaching',
                'administrative',
            ])->default('teaching');
            $table->string('subject')->nullable();      // e.g. 'Mathematics, Science'
            $table->string('grade_handled')->nullable();// e.g. 'Grade 5 & 6'

            $table->string('photo_path')->nullable();   // relative path in public disk
            $table->boolean('show_on_site')->default(true); // show on public About page
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('type');
            $table->index('status');
            $table->index('show_on_site');
            $table->index(['status', 'show_on_site']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty');
    }
};
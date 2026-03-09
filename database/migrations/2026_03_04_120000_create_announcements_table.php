<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('body');
            $table->enum('category', [
                'General',
                'Academic',
                'Notice',
                'Health',
                'Community',
            ])->default('General');
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->boolean('is_pinned')->default(false);
            $table->date('post_date');
            $table->date('expiry_date')->nullable();

            $table->foreignId('author_id')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for common queries
            $table->index('status');
            $table->index('category');
            $table->index('post_date');
            $table->index('is_pinned');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
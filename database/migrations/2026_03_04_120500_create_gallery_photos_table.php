<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
//  Albums must be created BEFORE gallery_photos
//  because gallery_photos has a FK → albums.id
// ============================================================

return new class extends Migration
{
    public function up(): void
    {
        // ── Albums ──────────────────────────────────────────
        Schema::create('albums', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->text('description')->nullable();

            // Cover photo set after photos exist — added via separate migration
            // or set nullable here and updated later
            $table->unsignedBigInteger('cover_photo_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // ── Gallery Photos ───────────────────────────────────
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('album_id')
                  ->nullable()
                  ->constrained('albums')
                  ->nullOnDelete();   // photo stays, just unalbummed

            $table->string('filename');             // UUID-based stored filename
            $table->string('original_name');        // original uploaded name
            $table->text('caption')->nullable();
            $table->string('disk')->default('public');   // 'public' | 's3'
            $table->string('path');                 // relative path on disk
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0); // bytes
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('album_id');
            $table->index('is_published');
            $table->index('sort_order');
        });

        // ── Now safe to add cover_photo FK on albums ────────
        Schema::table('albums', function (Blueprint $table) {
            $table->foreign('cover_photo_id')
                  ->references('id')
                  ->on('gallery_photos')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Drop FK first to avoid constraint errors
        Schema::table('albums', function (Blueprint $table) {
            $table->dropForeign(['cover_photo_id']);
        });

        Schema::dropIfExists('gallery_photos');
        Schema::dropIfExists('albums');
    }
};
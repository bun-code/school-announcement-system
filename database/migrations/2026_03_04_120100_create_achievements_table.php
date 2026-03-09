<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['honor', 'competition']);

            // ── Honor roll fields ──────────────────────────
            $table->string('student_name')->nullable();
            $table->string('grade')->nullable();       // e.g. 'Grade 6'
            $table->string('section')->nullable();     // e.g. 'Mabini'
            $table->decimal('gwa', 5, 2)->nullable();  // e.g. 98.50
            $table->enum('honors', [
                'With Highest Honors',
                'With High Honors',
                'With Honors',
            ])->nullable();
            $table->string('quarter')->nullable();     // 'Q1' | 'Q2' | 'Q3' | 'Q4'
            $table->string('school_year', 20)->nullable(); // e.g. '2025–2026'

            // ── Competition fields ─────────────────────────
            $table->string('competition_name')->nullable();
            $table->text('student_names')->nullable();  // comma-separated or JSON
            $table->string('category')->nullable();     // e.g. 'Math', 'Science'
            $table->enum('level', [
                'School',
                'District',
                'Division',
                'Regional',
                'National',
            ])->nullable();
            $table->enum('place', [
                '1st Place',
                '2nd Place',
                '3rd Place',
                'Finalist',
                'Special Award',
            ])->nullable();
            $table->date('event_date')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('type');
            $table->index('school_year');
            $table->index('quarter');
            $table->index('level');
            $table->index(['type', 'school_year', 'quarter']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
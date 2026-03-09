<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category',
        'event_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'status',       // 'upcoming' | 'completed' | 'cancelled'
    ];

    protected $casts = [
        'event_date' => 'date',
        'end_date'   => 'date',
    ];

    // ── Scopes ──

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->startOfDay())
                     ->orderBy('event_date');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->startOfDay())
                     ->orderByDesc('event_date');
    }

    public function scopeInMonth($query, int $year, int $month)
    {
        return $query->whereYear('event_date', $year)
                     ->whereMonth('event_date', $month);
    }

    // ── Accessors ──

    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'Sports'    => 'badge--green',
            'Cultural'  => 'badge--orange',
            'Program'   => 'badge--purple',
            'Community' => 'badge--amber',
            'Health'    => 'badge--red',
            default     => 'badge--blue',  // Academic
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'completed'  => 'badge--green',
            'cancelled'  => 'badge--red',
            'scheduled'  => 'badge--gray',
            default      => 'badge--blue',  // upcoming
        };
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'category',
        'status',       // 'published' | 'draft'
        'is_pinned',
        'post_date',
        'expiry_date',
        'author_id',
    ];

    protected $casts = [
        'is_pinned'   => 'boolean',
        'post_date'   => 'date',
        'expiry_date' => 'date',
    ];

    // ── Relationships ──

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // ── Scopes ──

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '0000-00-00')
              ->orWhereDate('expiry_date', '>=', today());
        });
    }

    // ── Accessors ──

    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'Academic'  => 'badge--purple',
            'Notice'    => 'badge--orange',
            'Health'    => 'badge--amber',
            'Community' => 'badge--green',
            default     => 'badge--blue',  // General
        };
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status === 'published' ? 'badge--green' : 'badge--gray';
    }
}

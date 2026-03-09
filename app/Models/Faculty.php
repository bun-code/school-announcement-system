<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faculty'; // explicit — avoids 'faculties' pluralization

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'type',           // 'teaching' | 'non-teaching' | 'administrative'
        'subject',
        'grade_handled',
        'photo_path',
        'show_on_site',   // boolean — display on public About page
        'status',         // 'active' | 'inactive'
    ];

    protected $casts = [
        'show_on_site' => 'boolean',
    ];

    // ── Accessors ──

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(
            substr($this->first_name, 0, 1) .
            substr($this->last_name, 0, 1)
        );
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path
            ? Storage::disk('public')->url($this->photo_path)
            : null;
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'non-teaching'   => 'badge--gray',
            'administrative' => 'badge--purple',
            default          => 'badge--blue',  // teaching
        };
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeTeaching($query)
    {
        return $query->where('type', 'teaching');
    }

    public function scopeVisibleOnSite($query)
    {
        return $query->where('show_on_site', true)->where('status', 'active');
    }
}
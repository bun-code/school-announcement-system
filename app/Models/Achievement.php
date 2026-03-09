<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',             // 'honor' | 'competition'
        // Honor fields
        'student_name',
        'grade',
        'section',
        'gwa',
        'honors',           // 'With Highest Honors' | 'With High Honors' | 'With Honors'
        'quarter',
        'school_year',
        // Competition fields
        'competition_name',
        'student_names',    // comma-separated or JSON for multi-student wins
        'category',
        'level',            // 'School' | 'District' | 'Division' | 'Regional' | 'National'
        'place',            // '1st Place' | '2nd Place' etc.
        'event_date',
    ];

    protected $casts = [
        'gwa'        => 'decimal:2',
        'event_date' => 'date',
    ];

    // ── Scopes ──

    public function scopeHonors($query)
    {
        return $query->where('type', 'honor');
    }

    public function scopeCompetitions($query)
    {
        return $query->where('type', 'competition');
    }

    public function scopeForYear($query, string $schoolYear)
    {
        return $query->where('school_year', $schoolYear);
    }

    // ── Accessors ──

    public function getHonorsColorAttribute(): string
    {
        return match($this->honors) {
            'With Highest Honors' => 'badge--amber',
            'With High Honors'    => 'badge--blue',
            default               => 'badge--green',
        };
    }

    public function getPlaceColorAttribute(): string
    {
        return match($this->place) {
            '1st Place' => 'badge--blue',
            '2nd Place' => 'badge--green',
            '3rd Place' => 'badge--orange',
            default     => 'badge--gray',
        };
    }
}
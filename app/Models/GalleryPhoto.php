<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class GalleryPhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'album_id',
        'filename',
        'original_name',
        'caption',
        'disk',
        'path',
        'mime_type',
        'size',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'size'         => 'integer',
        'sort_order'   => 'integer',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1_048_576) return round($bytes / 1_048_576, 1) . ' MB';
        if ($bytes >= 1_024)     return round($bytes / 1_024, 0) . ' KB';
        return $bytes . ' B';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeUnalbummed($query)
    {
        return $query->whereNull('album_id');
    }
}
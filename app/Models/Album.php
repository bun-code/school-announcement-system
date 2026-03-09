<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GalleryPhoto;

class Album extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'cover_photo_id',
    ];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'album_id');
    }

    public function coverPhoto()
    {
        return $this->belongsTo(GalleryPhoto::class, 'cover_photo_id');
    }

    public function getPhotoCountAttribute(): int
    {
        return $this->photos()->count();
    }
}
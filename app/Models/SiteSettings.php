<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table        = 'site_settings';
    protected $primaryKey   = 'key';
    protected $keyType      = 'string';
    public    $incrementing = false;
    public    $timestamps   = false;

    protected $fillable = ['key', 'value'];

    // ── Get a single setting value ────────────────────────────
    public static function get(string $key, mixed $default = null): mixed
    {
        $row = static::where('key', $key)->first();
        return $row ? $row->value : $default;
    }

    // ── Set a single setting value ────────────────────────────
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    // ── Get all settings as key => value array ────────────────
    public static function allAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DendaSetting extends Model
{
    protected $table    = 'denda_settings';
    protected $fillable = ['key', 'value', 'label', 'satuan'];

    /**
     * Get setting value by key, with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}

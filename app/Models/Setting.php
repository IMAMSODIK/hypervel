<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever('setting:'.$key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting?->value ?? $default;
        });
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('setting:'.$key);
    }

    public static function getMany(array $keys): array
    {
        return collect($keys)->mapWithKeys(fn ($key) => [$key => static::get($key)])->all();
    }

    public static function flush(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget('setting:'.$key);
        }
    }
}
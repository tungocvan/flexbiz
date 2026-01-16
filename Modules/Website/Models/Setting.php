<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $table = 'wp_settings';
    protected $fillable = ['key', 'value', 'group_name', 'type', 'label'];

    // Helper: Lấy giá trị setting theo key (có Cache để nhanh)
    public static function getValue($key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    // Helper: Lưu giá trị và xóa Cache
    public static function setValue($key, $value, $group = 'general')
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group_name' => $group]
        );
        Cache::forget('setting_' . $key);
    }
}

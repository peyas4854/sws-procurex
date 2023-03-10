<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SettingService
{
    public static function updateOrCreate($key, $value = null)
    {

        Setting::updateOrCreate(
            ["key" => $key],
            ["value" => ($key == 'weekly_holidays' || $key == 'departments' || $key == 'cost_centers') ? json_encode($value) :$value ]
        );

        return true;
    }

    public static function all($reloadCache = false)
    {
        if($reloadCache === true){
            Cache::forget("settings");
        }

        if (Cache::has('settings')) {
            return Cache::get("settings");
        }

        $settings = Setting::get([
            'key', 'value'
        ]);

        if ($settings->count() < 1) {
            return [];
        }

        $mySettings = [];

        foreach ($settings as $setting) {
            $mySettings[$setting->key] = $setting->value;
        }

        // Store settings into cache for X hours
        Cache::put('settings', $mySettings, now()->addHour(config("app.settings_cache_expiration_time")));

        return $mySettings;
    }

    public static function get($key, $default = null)
    {
        $settings = self::all();
        return $settings[$key] ?? $default;
    }

    public static function getAll()
    {
        return self::all();
    }

    public function delete($key)
    {
        return (bool) Setting::whereKey($key)->delete();
    }

    public static function reloadSettingsCache() :void
    {
        self::all(true);
    }
}

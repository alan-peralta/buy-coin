<?php

namespace App\Services;

use App\Models\SystemConfiguration;
use Illuminate\Support\Facades\Cache;

class GetCoinDefaultService
{
    public static function execute()
    {
        return Cache::remember('coin.default', now()->day(1), function () {
            return SystemConfiguration::query()->where('key', 'currency.origin.default')->pluck('value')->first();
        });
    }

}

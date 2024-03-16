<?php

namespace App\Services;

use App\Models\SystemConfiguration;
use Illuminate\Support\Facades\Cache;

class GetMinimunAmountService
{
    public static function execute()
    {
        return Cache::remember('minimum.amount', now()->day(1), function () {
            return SystemConfiguration::query()->where('key', 'minimum.allowed.amount')->pluck('value')->first();
        });
    }
}

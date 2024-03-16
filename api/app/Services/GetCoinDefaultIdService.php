<?php

namespace App\Services;

use App\Models\Coin;
use Illuminate\Support\Facades\Cache;

class GetCoinDefaultIdService
{
    public static function execute()
    {
        return Cache::remember('coin.default.id', now()->day(1), function ()  {
            $coinDefault = GetCoinDefaultService::execute();
            return Coin::query()->toBase()->where('acronym', $coinDefault)->pluck('id')->first();
        });
    }
}

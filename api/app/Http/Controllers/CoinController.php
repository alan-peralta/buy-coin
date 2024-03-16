<?php

namespace App\Http\Controllers;

use App\Models\CoinCombination;
use App\Models\SystemConfiguration;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CoinController extends Controller
{
    public function getAll(): JsonResponse
    {
        $defaultCoin = SystemConfiguration::query()->where('key', 'currency.origin.default')->pluck('value')->first();

        $coins = CoinCombination::query()
            ->where('to.acronym', $defaultCoin)
            ->where('coin_combinations.is_active', 1)
            ->join('coins as from', 'from_coin_id', 'from.id')
            ->join('coins as to', 'to_coin_id', 'to.id')
            ->orderBy('from.acronym')
            ->pluck(DB::raw("CONCAT(from.acronym, ' - ', from.name) as currency"), 'from.id')
            ->toArray();

        return response()->json($coins);

    }
}

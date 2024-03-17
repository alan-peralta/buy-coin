<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteResource;
use App\Interfaces\GetQuoteServiceInterface;
use App\Models\CoinCombination;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function index(): QuoteResource
    {
        $coins = CoinCombination::query()->toBase()
            ->where('coin_combinations.is_active', 1)
            ->join('coins as from', 'from_coin_id', 'from.id')
            ->join('coins as to', 'to_coin_id', 'to.id');

            $data = [];
            foreach ($coins->get(["to.acronym as to", "from.acronym as from"]) as $item) {
                $data[] = $item->from . "-" . $item->to;
            }
            $coins = $data;

        $currency = implode(",", $coins);

        $quotes = app(GetQuoteServiceInterface::class)->execute($currency);

        return new QuoteResource($quotes);
    }
}

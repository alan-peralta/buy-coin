<?php

namespace App\Services;

use App\Models\CoinTax;

class GetTaxAmountService
{
    public function execute(int $fromCoinId, int $toCoinId, int $amount)
    {
        $coinTax = CoinTax::query()->toBase()->where('from_coin_id', $fromCoinId)->where('to_coin_id', $toCoinId)->first();

        $tax = (int)($amount / (1 - ($coinTax->percent / config('services.money.percent_multiplier'))));
        $tax += $coinTax->amount;
        $tax -= $amount;

        return $tax;
    }

}

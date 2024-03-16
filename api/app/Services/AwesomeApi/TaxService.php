<?php

namespace App\Services\AwesomeApi;

use App\Interfaces\TaxServiceInterface;
use App\Models\CoinTax;

class TaxService implements TaxServiceInterface
{

    public function get($from, $to)
    {
        $tax = CoinTax::query()->where('from_coin_id', $from)->where('to_coin_id', $to)->first();

        if (!$tax) {
            //
        }

        return $tax;
    }
}

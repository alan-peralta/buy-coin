<?php

namespace App\Services\Quote;

use App\Models\Quote;

class CreateQuoteService
{
    public function execute(array $data): Quote
    {
        $quote = new Quote();
        $quote->from = $data['code'];
        $quote->to = $data['codein'];
        $quote->bid = $data['bid'] * 10000;
        $quote->bid_decimals = 4;
        $quote->ask = $data['ask'] * 10000;
        $quote->ask_decimals = 4;
        $quote->save();

        return $quote;
    }
}

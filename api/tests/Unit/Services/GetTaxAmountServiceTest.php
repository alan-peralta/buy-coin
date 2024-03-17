<?php

namespace Services;

use App\Models\Coin;
use App\Services\GetTaxAmountService;
use Tests\TestCase;

class GetTaxAmountServiceTest extends TestCase
{
    public function testGetTaxAmountService()
    {
        $fromId = Coin::query()->where('acronym', 'USD')->pluck('id')->first();
        $toId = Coin::query()->where('acronym', 'BRL')->pluck('id')->first();
        $tax = (new GetTaxAmountService())->execute($fromId, $toId, 10000);

        $this->assertEquals(204, $tax);
    }

}

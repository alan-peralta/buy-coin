<?php

namespace Tests\Unit\AwesomeApi;

use App\Models\Coin;
use App\Models\CoinCombination;
use App\Models\CoinTax;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\Mocks\AwesomeApi\AwesomeApiMocks;
use Tests\TestCase;

class GetCoinsTest extends TestCase
{
    use AwesomeApiMocks;

    protected function setUp(): void
    {
        parent::setUp();
        CoinTax::query()->truncate();
        CoinCombination::query()->truncate();
        Coin::query()->truncate();
    }

    public function testHandleSuccess(): void
    {
        Http::fake([
            '*awesomeapi.com.br/json/available/uniq' => Http::response($this->getCoins())
        ]);

        $coins = Coin::query()->count();
        $this->assertEquals(0, $coins);

        Artisan::call('awesomeApi:get-coins');

        $coins = Coin::query()->count();
        $this->assertEquals(14, $coins);
    }

    public function testHandleError(): void
    {
        Http::fake([
            '*awesomeapi.com.br/json/available/uniq' => Http::response([], Response::HTTP_NOT_FOUND)
        ]);

        $this->expectException(HttpClientException::class);

        Artisan::call('awesomeApi:get-coins');
    }
}

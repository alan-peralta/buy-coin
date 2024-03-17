<?php

namespace AwesomeApi;

use App\Models\Coin;
use App\Models\CoinCombination;
use App\Models\CoinTax;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\Mocks\AwesomeApi\AwesomeApiMocks;
use Tests\TestCase;

class GetCoinCombinationsTest extends TestCase
{
    use AwesomeApiMocks;

    protected function setUp(): void
    {
        parent::setUp();
        CoinTax::query()->truncate();
        CoinCombination::query()->truncate();
    }

    public function testHandleSuccess(): void
    {
        Http::fake([
            '*awesomeapi.com.br/json/available' => Http::response($this->quoteAvailable())
        ]);

        $coins = CoinCombination::query()->count();
        $this->assertEquals(0, $coins);

        Artisan::call('awesomeApi:get-coin-combinations');

        $coins = CoinCombination::query()->count();
        $this->assertEquals(32, $coins);
    }

    public function testHandleError(): void
    {
        Http::fake([
            '*awesomeapi.com.br/json/available' => Http::response([], Response::HTTP_NOT_FOUND)
        ]);

        $this->expectException(HttpClientException::class);

        Artisan::call('awesomeApi:get-coin-combinations');
    }

}

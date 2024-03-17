<?php

namespace Tests\Unit\Services;

use App\Services\AwesomeApi\GetQuoteService;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Tests\Mocks\AwesomeApi\AwesomeApiMocks;
use Tests\TestCase;

class GetQuoteServiceTest extends TestCase
{
    use AwesomeApiMocks;
    /**
     * @throws HttpClientException
     */
    public function testGetQuoteServiceSuccess()
    {
        Http::fake([
            '*awesomeapi.com.br/json/last*' => Http::response($this->getQuoteSelectCoin('USD', 'BRL'))
        ]);

        $response = (new GetQuoteService())->execute('USD-BRL');

        $this->assertArrayHasKey('USDBRL', $response);
        $this->assertArrayHasKey('code', $response['USDBRL']);
        $this->assertArrayHasKey('codein', $response['USDBRL']);
        $this->assertArrayHasKey('name', $response['USDBRL']);
        $this->assertArrayHasKey('high', $response['USDBRL']);
        $this->assertArrayHasKey('low', $response['USDBRL']);
        $this->assertArrayHasKey('varBid', $response['USDBRL']);
        $this->assertArrayHasKey('pctChange', $response['USDBRL']);
        $this->assertArrayHasKey('bid', $response['USDBRL']);
        $this->assertArrayHasKey('ask', $response['USDBRL']);
        $this->assertArrayHasKey('timestamp', $response['USDBRL']);
        $this->assertArrayHasKey('create_date', $response['USDBRL']);
    }

    public function testGetQuoteServiceError()
    {
        Http::fake([
            '*awesomeapi.com.br/json/last*' => Http::response('{
                "status": 404,
                "code": "CoinNotExists",
                "message": "moeda nao encontrada ABC-BRL"
            }', 404)
        ]);

        $this->expectException(HttpClientException::class);
        $response = (new GetQuoteService())->execute('USD-BRL');

        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('code', $response);
        $this->assertArrayHasKey('codein', $response);
        $this->assertArrayHasKey('message', $response);
    }

}

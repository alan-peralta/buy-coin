<?php

namespace Quote;

use App\Models\User;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\Mocks\AwesomeApi\AwesomeApiMocks;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    use AwesomeApiMocks;
    public function testGetQuoteAweSomeApi()
    {
        Http::fake([
            '*awesomeapi.com.br/json/last/*' => Http::response($this->getQuotes())
        ]);

        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = data_get($response->json(), 'token');

        $response = $this->withHeaders(['Authorization'=>'Bearer '.$token])->get('/api/v1/quotes');

        $response->assertStatus(200);
    }

    public function testGetQuoteCoinNotExistsAweSomeApi()
    {
        Http::fake([
            '*awesomeapi.com.br/json/last/*' => Http::response($this->coinNotExists(), Response::HTTP_NOT_FOUND)
        ]);

        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = data_get($response->json(), 'token');

        $this->expectException(HttpClientException::class);

        $response = $this->withHeaders(['Authorization'=>'Bearer '.$token])->get('/api/v1/quotes');

        $response->assertJsonStructure([
            "status",
            "code",
            "message"
        ]);
    }
}

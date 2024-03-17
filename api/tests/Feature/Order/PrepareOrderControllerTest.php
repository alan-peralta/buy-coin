<?php

namespace Order;

use App\Models\Coin;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\Mocks\AwesomeApi\AwesomeApiMocks;
use Tests\TestCase;

class PrepareOrderControllerTest extends TestCase
{
    use AwesomeApiMocks;

    public function testPrepareOrderSuccess(): void
    {
        Http::fake([
            '*awesomeapi.com.br/json/last*' => Http::response($this->getQuoteSelectCoin('USD', 'BRL'))
        ]);

        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = data_get($response->json(), 'token');

        $payload = [
            "coin_id" => Coin::query()->where('acronym', 'USD')->pluck('id')->first(),
            "amount" => $amount = 5000
        ];
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/prepare-order', $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "user_id",
            "amount",
            "amount_decimals",
            "amount_converted",
            "amount_converted_decimals",
            "tax",
            "quote_id",
            "status_id",
            "updated_at",
            "created_at",
            "id",
        ]);

        $this->assertEquals($user->id, data_get($response->json(), 'user_id'));
        $this->assertEquals($amount, data_get($response->json(), 'amount'));
        $this->assertEquals(2, data_get($response->json(), 'amount_decimals'));
        $this->assertEquals(1001, data_get($response->json(), 'amount_converted'));
        $this->assertEquals(2, data_get($response->json(), 'amount_converted_decimals'));
        $this->assertEquals(102, data_get($response->json(), 'tax'));
        $this->assertEquals(1, data_get($response->json(), 'quote_id'));
        $this->assertEquals(1, data_get($response->json(), 'status_id'));
    }

    public function testPrepareOrderWithQuoteError(): void
    {
        Http::fake([
            '*awesomeapi.com.br/json/last*' => Http::response($this->getQuoteSelectCoin('USD', 'BRLT'))
        ]);

        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = data_get($response->json(), 'token');

        $payload = [
            "coin_id" => Coin::query()->where('acronym', 'USD')->pluck('id')->first(),
            "amount" => 5000
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/prepare-order', $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            "error" => ["message"]
        ]);
    }

    public function testPrepareOrderWithAmountLessThanMinimum(): void
    {
        Http::fake([
            '*awesomeapi.com.br/json/last*' => Http::response($this->getQuoteSelectCoin('USD', 'BRL'))
        ]);

        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = data_get($response->json(), 'token');

        $payload = [
            "coin_id" => Coin::query()->where('acronym', 'USD')->pluck('id')->first(),
            "amount" => 1
        ];

        $this->expectException(ValidationException::class);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/prepare-order', $payload);
        $this->assertEquals("The amount field must be at least 5000.", $response->json());
    }

    public function testPrepareOrderWithInvalidCoin(): void
    {
        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = data_get($response->json(), 'token');

        $payload = [
            "coin_id" => 99999,
            "amount" => 50001
        ];

        $this->expectException(ValidationException::class);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/prepare-order', $payload);
        $this->assertEquals("The selected coin id is invalid.", $response->json());
    }
}

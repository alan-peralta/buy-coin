<?php

namespace Order;

use App\Models\Coin;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\Mocks\AwesomeApi\AwesomeApiMocks;
use Tests\TestCase;

class FinalizeOrderControllerTest extends TestCase
{
    use AwesomeApiMocks;

    public function testFinalizeOrderSuccess(): void
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
            "amount" => 5000
        ];
        $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/prepare-order', $payload);

        $payload = [
            "order_id" => 1,
            "status_id" => Status::APPROVED
        ];
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/finalize-order', $payload);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(Status::APPROVED, data_get($response->json(), 'status_id'));
    }

    public function testFinalizeOrderCanceled(): void
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
            "amount" => 5000
        ];
        $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/prepare-order', $payload);

        $payload = [
            "order_id" => 1,
            "status_id" => Status::CANCELLED
        ];
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/finalize-order', $payload);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(Status::CANCELLED, data_get($response->json(), 'status_id'));
    }

    public function testFinalizeOrderApproved(): void
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
            "amount" => 5000
        ];
        $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/prepare-order', $payload);

        $payload = [
            "order_id" => 1,
            "status_id" => Status::NEW
        ];

        $this->expectException(ValidationException::class);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/v1/finalize-order', $payload);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals("The selected status id is invalid.", $response->json());
    }
}

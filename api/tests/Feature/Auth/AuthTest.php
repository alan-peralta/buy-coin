<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testRegisterUser(): void
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password')
        ];

        $response = $this->post('api/v1/auth/register', $payload);

        $response->assertOk();

        $response->assertJsonStructure([
            'type',
            'token'
        ]);
    }

    public function testRegisterUserFailEmail(): void
    {
        $payload = [
            'name' => fake()->name(),
            'email' => 'teste',
            'password' => Hash::make('password')
        ];

        $response = $this->post('api/v1/auth/register', $payload);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('email', $content);
    }

    public function testRegisterUserFailEmailUnique(): void
    {
        $payload = [
            'name' => fake()->name(),
            'email' => $email = fake()->unique()->safeEmail(),
            'password' => Hash::make('password')
        ];

        $response = $this->post('api/v1/auth/register', $payload);
        $response->assertOk();

        $payload = [
            'name' => fake()->name(),
            'email' => $email,
            'password' => Hash::make('password')
        ];

        $response = $this->post('api/v1/auth/register', $payload);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals("The email has already been taken.", data_get($content, "email.0"));
    }

    public function testLoginSuccessfully()
    {
        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'type',
            'token'
        ]);
    }

    public function testLoginWithEmailError()
    {
        $response = $this->post('api/v1/auth/login', [
            'email' => 'email@error.com',
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals("Email & Password does not match with our record.", data_get($response->json(), "error.message"));
    }

    public function testLoginWithPasswordError()
    {
        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password1'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertEquals("Email & Password does not match with our record.", data_get($response->json(), "error.message"));
    }

    public function testLogoutSuccessfully()
    {
        $user = User::factory()->create();

        $response = $this->post('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'type',
            'token'
        ]);

        $response = $this->post('api/v1/auth/logout');

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}

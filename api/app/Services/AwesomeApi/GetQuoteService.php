<?php

namespace App\Services\AwesomeApi;

use App\Interfaces\GetQuoteServiceInterface;
use App\Models\Quote;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GetQuoteService implements GetQuoteServiceInterface
{
    private string $base_url;

    public function __construct()
    {
        $this->base_url = config('services.awesome_api.base_url');
    }

    /**
     * @throws HttpClientException
     */
    public function execute($currency)
    {
        $response = Http::retry(5)->get($this->base_url . '/json/last/' . $currency);

        if (!$response->successful()) {
            $response->throw();
        }

        return $response->json();
    }
}

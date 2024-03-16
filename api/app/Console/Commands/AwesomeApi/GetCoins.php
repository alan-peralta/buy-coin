<?php

namespace App\Console\Commands\AwesomeApi;

use App\Models\Coin;
use Illuminate\Console\Command;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;

class GetCoins extends Command
{
    protected $signature = 'awesomeApi:get-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search available currencies for exchange';

    /**
     * Execute the console command.
     * @throws HttpClientException
     */
    public function handle()
    {
        $response = Http::retry(5)->get('https://economia.awesomeapi.com.br/json/available/uniq');

        if (!$response->successful()) {
            throw new HttpClientException();
        }

        foreach ($response->json() as $key => $item) {
            Coin::query()->updateOrCreate([
                'acronym' => $key
            ], [
                'name' => $item
            ]);
        }
    }
}

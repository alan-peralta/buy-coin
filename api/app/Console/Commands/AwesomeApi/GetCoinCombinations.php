<?php

namespace App\Console\Commands\AwesomeApi;

use App\Models\Coin;
use App\Models\CoinCombination;
use App\Models\SystemConfiguration;
use Illuminate\Console\Command;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GetCoinCombinations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'awesomeApi:get-coin-combinations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for available combinations for exchange';

    /**
     * Execute the console command.
     * @throws HttpClientException
     */
    public function handle()
    {
        $response = Http::retry(5)->get('https://economia.awesomeapi.com.br/json/available');

        if (!$response->successful()) {
            throw new HttpClientException();
        }

        $coins = Coin::query()->toBase()->pluck('id', 'acronym');

        foreach ($response->json() as $key => $item) {
            $acronym = explode('-', $key);

            $from = Arr::get($coins, reset($acronym));
            $to = Arr::get($coins, end($acronym));

            if (!$from || !$to) {
                continue;
            }

            CoinCombination::query()->updateOrCreate([
                'from_coin_id' => $from,
                'to_coin_id' => $to,
            ], [
                'name' => $item,
                'ís_active' => true
            ]);
        }



        $defaultCoin = SystemConfiguration::query()->where('key', 'currency.origin.default')->pluck('value')->first();

        if ($defaultCoin) {
            $coins = CoinCombination::query()->where('to_coin_id', Arr::get($coins, $defaultCoin))->get();
            foreach ($coins as $coin) {
                $coin->update(['is_active' => true]);
                Coin::query()->find($coin->from_coin_id)->update(['is_active' => true]);
            }
        }

    }
}

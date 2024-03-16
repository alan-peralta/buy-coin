<?php

namespace Database\Seeders;

use App\Models\CoinCombination;
use App\Models\CoinTax;
use App\Models\SystemConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoinTaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxDefault = SystemConfiguration::query()->toBase()->where('key', 'tax.default')->pluck('value')->first();

        $coinCombinations = CoinCombination::query()->where('is_active', true)->get();

        foreach ($coinCombinations as $coinCombination) {
            CoinTax::query()->create([
                'from_coin_id' => $coinCombination->from_coin_id,
                'to_coin_id' => $coinCombination->to_coin_id,
                'percent' => $taxDefault,
            ]);
        }
    }
}

<?php

namespace Model;

use App\Models\CoinCombination;
use Tests\TestCase;

class CoinCombinationTest extends TestCase
{
    public function testCreateCoinCombinationModel(): void
    {
        $coinCombination = new CoinCombination();
        $coinCombination->from_coin_id = 1;
        $coinCombination->to_coin_id = 7;
        $coinCombination->name = 'Dirham dos Emirados/ Argentino';
        $coinCombination->is_active = false;
        $coinCombination->save();

        $this->assertDatabaseHas('coin_combinations', [
            'from_coin_id' => 1,
            'to_coin_id' => 7,
            'name' => 'Dirham dos Emirados/ Argentino',
            'is_active' => false
        ]);
    }

    public function testRelationshipCoinModel(): void
    {
        $coin = CoinCombination::query()->with('from')->first();
        $this->assertArrayHasKey('id', $coin->from->getAttributes());
        $this->assertArrayHasKey('acronym', $coin->from->getAttributes());
        $this->assertArrayHasKey('name', $coin->from->getAttributes());
        $this->assertArrayHasKey('is_active', $coin->from->getAttributes()
        );
    }
}

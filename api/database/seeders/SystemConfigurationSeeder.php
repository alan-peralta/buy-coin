<?php

namespace Database\Seeders;

use App\Models\SystemConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::query()->create([
            'key' => 'minimum.allowed.amount',
            'value' => 5000
        ]);

        SystemConfiguration::query()->create([
            'key' => 'currency.origin.default',
            'value' => 'BRL'
        ]);

        SystemConfiguration::query()->create([
            'key' => 'tax.default',
            'value' => 200
        ]);
    }
}

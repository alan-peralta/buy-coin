<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            'id' => Status::NEW,
            'name' => 'Novo',
        ]);

        DB::table('statuses')->insert([
            'id' => Status::APPROVED,
            'name' => 'Aprovado',
        ]);

        DB::table('statuses')->insert([
            'id' => Status::CANCELLED,
            'name' => 'Cancelado',
        ]);

        DB::table('statuses')->insert([
            'id' => Status::EXPIRED,
            'name' => 'Expirado',
        ]);
    }
}

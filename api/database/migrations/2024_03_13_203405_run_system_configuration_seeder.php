<?php

use Database\Seeders\SystemConfigurationSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new SystemConfigurationSeeder())->run();
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coin_combinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_coin_id')->index();
            $table->unsignedBigInteger('to_coin_id')->index();
            $table->string('name');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['from_coin_id', 'to_coin_id'], 'coin_combination_unique');

            $table->foreign('from_coin_id')->references('id')->on('coins');
            $table->foreign('to_coin_id')->references('id')->on('coins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_combinations');
    }
};

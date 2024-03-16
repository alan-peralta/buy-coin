<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coin_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_coin_id');
            $table->unsignedBigInteger('to_coin_id');
            $table->integer('percent')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();

            $table->foreign('from_coin_id')->references('id')->on('coins');
            $table->foreign('to_coin_id')->references('id')->on('coins');

            $table->unique(['from_coin_id', 'to_coin_id'], 'from_to_coin_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_taxes');
    }
};

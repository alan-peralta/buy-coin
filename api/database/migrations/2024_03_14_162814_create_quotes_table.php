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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('from');
            $table->string('to');
            $table->bigInteger('bid');
            $table->integer('bid_decimals');
            $table->bigInteger('ask');
            $table->integer('ask_decimals');
            $table->bigInteger('bid_spread');
            $table->integer('bid_spread_decimals');
            $table->bigInteger('ask_spread');
            $table->integer('ask_spread_decimals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};

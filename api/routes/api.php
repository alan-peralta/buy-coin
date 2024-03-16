<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\Order\FinalizeOrderController;
use App\Http\Controllers\Order\PrepareOrderController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('quotes', [QuoteController::class, 'index']);
        Route::get('coins', [CoinController::class, 'getAll']);
        Route::post('prepare-order', PrepareOrderController::class);
        Route::post('finalize-order', FinalizeOrderController::class);
    });

});

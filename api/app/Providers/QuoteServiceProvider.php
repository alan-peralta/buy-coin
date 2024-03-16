<?php

namespace App\Providers;

use App\Interfaces\GetQuoteServiceInterface;
use App\Services\AwesomeApi\GetQuoteService;
use Illuminate\Support\ServiceProvider;

class QuoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GetQuoteServiceInterface::class, fn () => $this->app->make(GetQuoteService::class));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

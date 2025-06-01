<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Coin\Contracts\CoinApiContract::class,
            \App\Domain\Coin\Services\CoingeckoApiService::class
        );
        $this->app->bind(
            \App\Domain\Coin\Contracts\CoinChartDataContract::class,
            \App\Domain\Coin\Services\CoinChartDataService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

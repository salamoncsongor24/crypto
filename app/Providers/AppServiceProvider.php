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
        $this->app->bind(
            \App\Domain\Portfolio\Contracts\PortfolioChartDataContract::class,
            \App\Domain\Portfolio\Services\PortfolioChartDataService::class
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

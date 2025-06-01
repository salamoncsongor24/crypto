<?php

namespace App\Domain\Coin\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface CoinChartDataContract
{
    /**
     * Get the price chart data for a coin between two dates.
     *
     * @param string $id The ID of the coin.
     * @param Carbon $startDate The start date in 'Y-m-d H:i:s' format.
     * @param Carbon $endDate The end date in 'Y-m-d H:i:s' format.
     * @param int $intervalInMinutes The interval in minutes for the chart data.
     * @param string $currency The currency to fetch the prices in (default is "usd").
     *
     * @return Collection A collection of price chart data for the specified coin.
     */
    public function getCoinPriceChartDataBetweenDates(string $id, Carbon $startDate, Carbon $endDate, int $intervalInMinutes = 1, string $currency = "usd"): Collection;
}

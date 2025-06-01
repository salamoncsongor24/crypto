<?php

namespace App\Domain\Coin\Services;

use App\Domain\Coin\Contracts\CoinChartDataContract;
use App\Domain\Coin\Models\CoinPrice;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CoinChartDataService implements CoinChartDataContract
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
    public function getCoinPriceChartDataBetweenDates(string $id, Carbon $startDate, Carbon $endDate, int $intervalInMinutes = 1, string $currency = "usd", ): Collection
    {
        // If interval is 1 minute, we can just pull raw data.
        if ($intervalInMinutes === 1) {
            $prices = CoinPrice::where('coin_id', $id)
                ->where('currency', $currency)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at')
                ->get(['created_at', 'price']);

            return collect([
                'labels' => $prices->pluck('created_at')->map(fn($dt) => $dt->format('Y-m-d H:i')),
                'data' => $prices->pluck('price'),
            ]);
        }

        // Group by interval if it's larger than 1 minute
        $prices = CoinPrice::selectRaw("
                DATE_FORMAT(DATE_SUB(created_at, INTERVAL MINUTE(created_at) % ? MINUTE), '%Y-%m-%d %H:%i:00') as interval_time,
                AVG(price) as average_price
            ", [$intervalInMinutes])
            ->where('coin_id', $id)
            ->where('currency', $currency)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('interval_time')
            ->orderBy('interval_time')
            ->get();

        return collect([
            'labels' => $prices->pluck('interval_time'),
            'data' => $prices->pluck('average_price'),
        ]);
    }
}

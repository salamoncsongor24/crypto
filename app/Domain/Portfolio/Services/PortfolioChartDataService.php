<?php

namespace App\Domain\Portfolio\Services;

use App\Domain\Coin\Models\CoinPrice;
use App\Domain\Portfolio\Contracts\PortfolioChartDataContract;
use App\Domain\Portfolio\Models\Portfolio;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PortfolioChartDataService implements PortfolioChartDataContract
{
    /**
     * Get the portfolio value chart data between two dates.
     *
     * @param string $id The ID of the portfolio.
     * @param Carbon $startDate The start date for the chart data.
     * @param Carbon $endDate The end date for the chart data.
     * @param int $intervalInMinutes The interval in minutes for the chart data.
     * @param string $currency The currency to fetch the values in (default is "usd").
     *
     * @return Collection A collection of portfolio value chart data between the specified dates.
     */
    public function getPortfolioValueChartDataBetweenDates(string $id, Carbon $startDate, Carbon $endDate, int $intervalInMinutes = 1, string $currency = "usd"): Collection
    {
        $portfolio = Portfolio::with(['coins' => function ($query) {
            $query->withPivot('amount');
        }])->findOrFail($id);

        $values = [];

        foreach ($portfolio->coins as $coin) {
            $coinId = $coin->remote_id;
            $amount = $coin->pivot->amount;

            if ($intervalInMinutes === 1) {
                $prices = CoinPrice::where('coin_id', $coinId)
                    ->where('currency', $currency)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at')
                    ->get(['created_at', 'price']);
            } else {
                $prices = CoinPrice::selectRaw("
                    DATE_FORMAT(DATE_SUB(created_at, INTERVAL MINUTE(created_at) % ? MINUTE), '%Y-%m-%d %H:%i:00') as interval_time,
                    AVG(price) as average_price
                ", [$intervalInMinutes])
                    ->where('coin_id', $coinId)
                    ->where('currency', $currency)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->groupBy('interval_time')
                    ->orderBy('interval_time')
                    ->get()
                    ->mapWithKeys(fn($row) => [$row->interval_time => $row->average_price]);
            }

            foreach ($prices as $timestamp => $price) {
                $ts = $intervalInMinutes === 1
                    ? $price->created_at->format('Y-m-d H:i')
                    : $timestamp;

                $values[$ts] = ($values[$ts] ?? 0) + (
                    $intervalInMinutes === 1
                        ? $price->price * $amount
                        : $price * $amount
                );
            }
        }

        ksort($values);
        $labels = collect( array_keys($values));
        $data = collect(array_values($values));

        return collect([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}

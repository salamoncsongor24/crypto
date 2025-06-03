<?php

namespace App\Domain\Portfolio\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface PortfolioChartDataContract
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
    public function getPortfolioValueChartDataBetweenDates(string $id, Carbon $startDate, Carbon $endDate, int $intervalInMinutes = 1, string $currency = "usd"): Collection;
}

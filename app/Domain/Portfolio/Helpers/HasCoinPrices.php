<?php

namespace App\Domain\Portfolio\Helpers;

trait HasCoinPrices
{
    /**
     * Calculate the total value of the portfolio in the specified currency.
     *
     * @param string $currency The currency to calculate the total value in.
     * @return float The total value of the portfolio in the specified currency.
     */
    public function getTotalValue(string $currency): float
    {
        return $this->coins->sum(function ($coin) use ($currency) {
            return $coin->getCurrentPrice($currency) * $coin->pivot->amount;
        });
    }

    /**
     * Get the last updated timestamp for the current price of the first coin in the portfolio.
     *
     * @param string $currency The currency to check the last updated time for.
     *
     * @return \DateTime|null The last updated timestamp, or null if no coins are present.
     */
    public function getCoinPriceLastUpdated(string $currency): ?\DateTime
    {
        return $this->coins->first()?->getCurrentPriceLastUpdated($currency);
    }
}

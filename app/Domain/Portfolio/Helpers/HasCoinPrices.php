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
}

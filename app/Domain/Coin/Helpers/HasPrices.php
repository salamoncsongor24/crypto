<?php

namespace App\Domain\Coin\Helpers;

trait HasPrices
{
    /**
     * Get the current price of the coin in the specified currency.
     *
     * @param string $currency The currency to get the price in.
     *
     * @return float|null The current price of the coin in the specified currency, or null if not found.
     */
    public function getCurrentPrice(string $currency): ?float
    {
        return $this->prices()
            ->where('currency', $currency)
            ->orderByDesc('created_at')
            ->first()
            ?->price;
    }

    /**
     * Get the last updated timestamp for the current price of the coin in the specified currency.
     *
     * @param string $currency The currency to check the last updated time for.
     *
     * @return \DateTime|null The last updated timestamp, or null if no prices are present.
     */
    public function getCurrentPriceLastUpdated(string $currency): ?\DateTime
    {
        return $this->prices()
            ->where('currency', $currency)
            ->orderByDesc('created_at')
            ->first()
            ?->created_at;
    }
}

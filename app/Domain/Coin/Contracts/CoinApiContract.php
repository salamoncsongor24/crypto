<?php

namespace App\Domain\Coin\Contracts;

use Illuminate\Support\Collection;

interface CoinApiContract
{
    /**
     * Search for coins based on a query string.
     *
     * @param string $query The search query for coins
     *
     * @return Collection The collection of coins matching the search query
     */
    public function searchCoins(string $query): Collection;

    /**
     * Fetch the description of a coin.
     *
     * @param string $remote_id the id of the coin to fetch the description for
     *
     * @return string the description of the coin
     */
    public function fetchCoinDescription(string $remote_id): string;

    /**
     * Get the current price of a coin.
     *
     * @param string $remote_id the id of the coin to get the price for
     *
     * @return float
     */
    public function getCurrentPrice(string $remote_id): float;
}

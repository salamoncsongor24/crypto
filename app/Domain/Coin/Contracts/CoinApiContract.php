<?php

namespace App\Domain\Coin\Contracts;

use App\Domain\Coin\DataObjects\DataTransferObjects\DetailedApiResponseData;
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
     * Fetch the details of a coin.
     *
     * @param string $remote_id the id of the coin to fetch the details for
     *
     * @return DetailedApiResponseData the details of the coin
     */
    public function fetchCoinDetails(string $remote_id): DetailedApiResponseData;

    /**
     * Get the current price of a coin.
     *
     * @param string $remote_id the id of the coin to get the price for
     *
     * @return float
     */
    public function getCurrentPrice(string $remote_id): float;
}

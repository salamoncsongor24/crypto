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
     * Get the current price of coins.
     *
     * @param Collection $remote_ids A collection of remote IDs of the coins to fetch prices for
     *
     * @return Collection the current price of the coin in various currencies
     */
    public function getCurrentPrices(Collection $remote_ids): Collection;
}

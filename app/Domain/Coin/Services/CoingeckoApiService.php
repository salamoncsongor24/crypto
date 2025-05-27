<?php

namespace App\Domain\Coin\Services;

use App\Domain\Coin\Contracts\CoinApiContract;
use App\Domain\Coin\DataObjects\DataTransferObjects\SearchApiResponseData;
use App\Domain\Coin\Exceptions\CoinGeckoApiResponseErrorException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CoingeckoApiService implements CoinApiContract
{
    const API_BASE_URL = 'https://api.coingecko.com/api/v3';

    /**
     * Search for coins based on a query string.
     *
     * @param string $query The search query for coins
     *
     * @return Collection The collection of coins matching the search query
     */
    public function searchCoins(string $query): Collection
    {
        $response = Http::get(self::API_BASE_URL . '/search', [
            'query' => $query,
        ]);

        if (!$response->successful()) {
            throw new CoinGeckoApiResponseErrorException(
                'Failed to fetch coins from Coingecko API: ' . $response->body()
            );
        }

        $coinsRaw = $response->json()['coins'] ?? [];

        // this logic is needed to filter out invalid coins
        // that do not conform to the SearchApiResponseData structure
        $validCoins = collect($coinsRaw)->map(function ($coinData) {
            try {
                return SearchApiResponseData::from([
                    'remote_id' => $coinData['id'] ?? '',
                    'name' => $coinData['name'] ?? '',
                    'symbol' => $coinData['symbol'] ?? '',
                ]);
            } catch (\Throwable $e) {
                return null;
            }
        })->filter();

        return $validCoins->values();
    }

    /**
     * Fetch the description of a coin.
     *
     * @param string $remote_id the id of the coin to fetch the description for
     *
     * @return string the description of the coin
     */
    public function fetchCoinDescription(string $remote_id): string
    {
        $response = Http::get(self::API_BASE_URL . '/coins/' . $remote_id);

        if (!$response->successful()) {
            throw new CoinGeckoApiResponseErrorException(
                'Failed to fetch coin description from Coingecko API: ' . $response->body()
            );
        }

        $coinData = $response->json();

        return $coinData['description']['en'] ?? '';
    }

    /**
     * Get the current price of a coin.
     *
     * @param string $remote_id The id of the coin to get the price for
     *
     * @return float
     */
    public function getCurrentPrice(string $remote_id): float
    {
        // Implementation for fetching the current price of a coin from Coingecko API
        return 0.0;
    }
}

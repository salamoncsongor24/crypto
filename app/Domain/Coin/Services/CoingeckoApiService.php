<?php

namespace App\Domain\Coin\Services;

use App\Domain\Coin\Contracts\CoinApiContract;
use App\Domain\Coin\DataObjects\DataTransferObjects\DetailedApiResponseData;
use App\Domain\Coin\DataObjects\DataTransferObjects\PriceApiResponseData;
use App\Domain\Coin\DataObjects\DataTransferObjects\SearchApiResponseData;
use App\Domain\Coin\Exceptions\CoinGeckoApiResponseErrorException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoingeckoApiService implements CoinApiContract
{
    /**
     * Search for coins based on a query string.
     *
     * @param string $query The search query for coins
     *
     * @return Collection The collection of coins matching the search query
     */
    public function searchCoins(string $query): Collection
    {
        $response = Http::get(config('coingecko.api_base_url') . '/search', [
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
        return collect($coinsRaw)->map(function ($coinData) {
            try {
                return SearchApiResponseData::from([
                    'remote_id' => $coinData['id'] ?? '',
                    'name' => $coinData['name'] ?? '',
                    'symbol' => $coinData['symbol'] ?? '',
                ]);
            } catch (\Throwable $e) {
                return null;
            }
        })->filter()->values();
    }

    /**
     * Fetch the details of a coin.
     *
     * @param string $remote_id the id of the coin to fetch the details for
     *
     * @return DetailedApiResponseData the details of the coin
     */
    public function fetchCoinDetails(string $remote_id): DetailedApiResponseData
    {
        $response = Http::get(config('coingecko.api_base_url') . '/coins/' . $remote_id);

        if (!$response->successful()) {
            throw new CoinGeckoApiResponseErrorException(
                'Failed to fetch coin description from Coingecko API: ' . $response->body()
            );
        }

        $coinData = $response->json();

        return DetailedApiResponseData::from([
            'remote_id' => $coinData['id'] ?? '',
            'name' => $coinData['name'] ?? '',
            'symbol' => $coinData['symbol'] ?? '',
            'description' => $coinData['description']['en'] ?? '',
        ]);
    }

    /**
     * Get the current price of coins.
     *
     * @param Collection $remote_ids A collection of remote IDs of the coins to fetch prices for
     *
     * @return Collection the current price of the coin in various currencies
     */
    public function getCurrentPrices(Collection $remote_ids): Collection
    {
        $currency = config('currency.default_currency');

        $response = Http::get(config('coingecko.api_base_url') . '/simple/price', [
            'ids' => $remote_ids->implode(','),
            'vs_currencies' => $currency,
            'precision' => config('coingecko.precision'),
        ]);

        if (!$response->successful()) {
            throw new CoinGeckoApiResponseErrorException(
                'Failed to fetch current prices from Coingecko API: ' . $response->body()
            );
        }

        $pricesRaw = $response->json();

        return collect($pricesRaw)->map(function ($priceData, $remoteId) use ($currency) {
            try {
                return PriceApiResponseData::from([
                    'remote_id' => $remoteId,
                    'price' => $priceData[$currency],
                    'currency' => $currency,
                ]);
            } catch (\Throwable $e) {
                Log::error($remoteId . ' price data is not valid');
                return null;
            }
        })->filter()->values();
    }
}

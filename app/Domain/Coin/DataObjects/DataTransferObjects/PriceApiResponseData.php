<?php

namespace App\Domain\Coin\DataObjects\DataTransferObjects;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class PriceApiResponseData extends Data
{
    /**
     * Represents a data transfer object for the price API response.
     *
     * @param string $remote_id The unique identifier of the coin.
     * @param float $prices The current price of the coin in the specified currency.
     */
    public function __construct(
        #[Exists('coins', 'remote_id')]
        public string $remote_id,

        public float $price,
    ) {
    }
}

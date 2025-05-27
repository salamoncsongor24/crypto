<?php

namespace App\Domain\Coin\DataObjects\DataTransferObjects;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class DetailedApiResponseData extends Data
{
    /**
     * Represents a data transfer object for a coin search API response.
     *
     * @param string $id The unique identifier of the coin.
     * @param string $name The name of the coin.
     * @param string $symbol The symbol of the coin.
     * @param string|null $description A detailed description of the coin.
     */
    public function __construct(
        #[Unique('coins', 'remote_id'), Max(255)]
        public string $remote_id,

        #[Max(255)]
        public string $name,

        #[Max(255)]
        public string $symbol,

        #[Max(65535)]
        public ?string $description,
    ) {
    }
}

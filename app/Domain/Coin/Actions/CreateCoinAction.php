<?php

namespace App\Domain\Coin\Actions;

use App\Domain\Coin\DataObjects\DataTransferObjects\CoinCreationData;
use App\Domain\Coin\Events\CoinCreatedEvent;
use App\Domain\Coin\Models\Coin;

class CreateCoinAction
{
    /**
     * Create a new coin instance from the provided data.
     *
     * @param CoinCreationData $data The data to create the coin
     * @param bool|null $shouldNotify Whether to notify after creation
     *
     * @return Coin The created coin instance
     */
    public function __invoke(CoinCreationData $data, bool $shouldNotify = false): Coin
    {
        $coin = Coin::create($data->toArray());

        CoinCreatedEvent::dispatch(
            $coin,
            $shouldNotify
        );

        return $coin;
    }
}

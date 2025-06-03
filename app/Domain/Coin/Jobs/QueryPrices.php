<?php

namespace App\Domain\Coin\Jobs;

use App\Domain\Coin\Contracts\CoinApiContract;
use App\Domain\Coin\DataObjects\Enums\CoinStatus;
use App\Domain\Coin\Models\Coin;
use App\Domain\Coin\Models\CoinPrice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class QueryPrices implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(CoinApiContract $coinService): void
    {
        $coin_ids = Coin::where('status', CoinStatus::active())
            ->get()
            ->pluck('remote_id');

        if ($coin_ids->isEmpty()) {
            return;
        }

        $prices = $coinService->getCurrentPrices($coin_ids);

        CoinPrice::insert(
            $prices->map(function ($price) {
                return [
                    'coin_id' => $price->remote_id,
                    'currency' => $price->currency,
                    'price' => $price->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray()
        );
    }
}

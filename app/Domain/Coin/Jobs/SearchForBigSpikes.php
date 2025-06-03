<?php

namespace App\Domain\Coin\Jobs;

use App\Domain\Coin\Events\CoinPriceChangedSignificantly;
use App\Domain\Coin\Models\Coin;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class SearchForBigSpikes implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currency = config('currency.default_currency');
        $sensitivity = config('notification.price_change.sensitivity');

        // Subquery: get min and max price per coin in the last 24 hours
        $priceChanges = DB::table('coin_prices')
            ->select('coin_id',
                DB::raw('MIN(price) as min_price'),
                DB::raw('MAX(price) as max_price')
            )
            ->where('currency', $currency)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->groupBy('coin_id');

        // Main query: filter coins with X%+ increase or decrease based on sensitivity
        $volatileCoins = DB::table(DB::raw("({$priceChanges->toSql()}) as price_stats"))
            ->mergeBindings($priceChanges)
            ->where(function ($query) use ($sensitivity) {
                $query->whereRaw('(max_price - min_price) / min_price >= ?', [$sensitivity])
                    ->orWhereRaw('(min_price - max_price) / max_price >= ?', [$sensitivity]);
            })
            ->pluck('coin_id');

        if (!$volatileCoins) {
            return;
        }

        CoinPriceChangedSignificantly::dispatch(Coin::whereIn('remote_id', $volatileCoins)->get());
    }
}

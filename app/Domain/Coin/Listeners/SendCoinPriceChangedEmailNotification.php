<?php

namespace App\Domain\Coin\Listeners;

use App\Domain\Coin\Events\CoinPriceChangedSignificantly;
use App\Domain\Coin\Mail\CoinsPriceChanged;
use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCoinPriceChangedEmailNotification
{
    /**
     * Handle the event.
     */
    public function handle(CoinPriceChangedSignificantly $event): void
    {
        Log::info('Email notification Sender. The price of the following coins changed significantly: ' . $event->coins->implode(', '));

        $users = User::where('get_notifications', true)->get();

        Mail::to($users)->queue(new CoinsPriceChanged($event->coins));
    }
}

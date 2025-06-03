<?php

namespace App\Domain\Coin\Listeners;

use App\Domain\Coin\Events\CoinPriceChangedSignificantly;
use App\Domain\User\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SendCoinPriceChangedDatabaseNotification
{
    /**
     * Handle the event.
     */
    public function handle(CoinPriceChangedSignificantly $event): void
    {
        Log::info('Database notification Sender. The price of the following coins changed significantly: ' . $event->coins->pluck('name')->implode(', '));

        $users = User::all();

        Notification::make()
            ->title('Heavy coin value changes in the last 24 hours!')
            ->body('The price of the following coins changed significantly: ' . $event->coins->pluck('name')->implode(', '))
            ->warning()
            ->sendToDatabase($users);
    }
}

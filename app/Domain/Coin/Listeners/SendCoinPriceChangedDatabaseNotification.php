<?php

namespace App\Domain\Coin\Listeners;

use App\Domain\User\Models\User;
use App\Events\CoinPriceChangedSignificantly;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SendCoinPriceChangedDatabaseNotification
{
    /**
     * Handle the event.
     */
    public function handle(CoinPriceChangedSignificantly $event): void
    {
        Log::info('Database notification Sender. The price of the following coins changed significantly: ' . $event->coins->implode(', '));

        $users = User::all();

        Notification::make()
            ->title('Heavy coin value changes in the last 24 hours!')
            ->body('The price of the following coins changed significantly: ' . $event->coins->implode(', '))
            ->warning()
            ->sendToDatabase($users);
    }
}

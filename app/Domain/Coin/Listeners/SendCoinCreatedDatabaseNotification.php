<?php

namespace App\Domain\Coin\Listeners;

use App\Domain\Coin\Events\CoinCreatedEvent;
use App\Domain\User\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SendCoinCreatedDatabaseNotification
{
    /**
     * Handle the event.
     */
    public function handle(CoinCreatedEvent $event): void
    {
        Log::info('Coin created! Database notification Sender:', [
            'coin_id' => $event->coin->id,
            'remote_id' => $event->coin->remote_id,
            'should_notify' => $event->shouldNotify,
        ]);

        if (! $event->shouldNotify) {
            return;
        }

        $users = User::all();

        Notification::make()
            ->title(__('New coin created: :name', ['name' => $event->coin->name]))
            ->body(__(':name has just been added to our platform. Go, check it out!', ['name' => $event->coin->name]))
            ->success()
            ->sendToDatabase($users);
    }
}

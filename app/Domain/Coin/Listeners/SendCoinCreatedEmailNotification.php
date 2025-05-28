<?php

namespace App\Domain\Coin\Listeners;

use App\Domain\Coin\Events\CoinCreatedEvent;
use App\Domain\Coin\Mail\CoinCreated;
use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCoinCreatedEmailNotification
{
    /**
     * Handle the event.
     */
    public function handle(CoinCreatedEvent $event): void
    {
        Log::info('Coin created! Email notification Sender:', [
            'coin_id' => $event->coin->id,
            'remote_id' => $event->coin->remote_id,
            'should_notify' => $event->shouldNotify,
        ]);

        if (! $event->shouldNotify) {
            return;
        }

        // TODO: only subscribed users should receive the notification
        $users = User::all();

        Mail::to($users)->queue(new CoinCreated($event->coin));
    }
}

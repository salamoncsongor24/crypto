<?php

namespace App\Domain\Coin\Events;

use App\Domain\Coin\Models\Coin;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CoinCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Coin $coin,
        public ?bool $shouldNotify = false,
    ) {}
}

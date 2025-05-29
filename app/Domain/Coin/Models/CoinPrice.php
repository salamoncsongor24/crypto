<?php

namespace App\Domain\Coin\Models;

use Database\Factories\CoinPriceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoinPrice extends Model
{
    /** @use HasFactory<\Database\Factories\CoinPriceFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'coin_id',
        'currency',
        'price',
    ];

    /**
     * The coin that this price belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Domain\Coin\Models\Coin>
     */
    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Database\Factories\CoinPriceFactory
     */
    protected static function newFactory(): CoinPriceFactory
    {
        return CoinPriceFactory::new();
    }
}

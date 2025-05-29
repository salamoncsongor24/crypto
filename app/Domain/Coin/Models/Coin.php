<?php

namespace App\Domain\Coin\Models;

use App\Domain\Coin\DataObjects\Enums\CoinStatus;
use App\Domain\Coin\Helpers\HasPrices;
use App\Domain\Coin\Scopes\ActiveScope;
use App\Domain\Portfolio\Models\Portfolio;
use Database\Factories\CoinFactory;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([ActiveScope::class])]
class Coin extends Model
{
    use HasFactory, SoftDeletes, HasPrices;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'remote_id',
        'name',
        'symbol',
        'description',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => CoinStatus::class,
        ];
    }

    /**
     * The portfolios that belong to the coin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Domain\Portfolio\Models\Portfolio>
     */
    public function portfolios(): BelongsToMany
    {
        return $this->belongsToMany(Portfolio::class, 'portfolio_coin', 'coin_id', 'portfolio_id')
            ->withPivot('amount');
    }

    /**
     * The prices associated with the coin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Domain\Coin\Models\CoinPrice>
     */
    public function prices(): HasMany
    {
        return $this->hasMany(CoinPrice::class, 'coin_id', 'id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Database\Factories\CoinFactory
     */
    protected static function newFactory(): CoinFactory
    {
        return CoinFactory::new();
    }
}

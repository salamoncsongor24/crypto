<?php

namespace App\Domain\Portfolio\Models;

use App\Domain\Coin\Models\Coin;
use App\Domain\Portfolio\Helpers\HasCoinPrices;
use App\Domain\User\Models\User;
use Database\Factories\PortfolioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes, HasCoinPrices;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'is_public',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * The user that owns the portfolio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Domain\User\Models\User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The coins that belong to the portfolio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Domain\Coin\Models\Coin>
     */
    public function coins(): BelongsToMany
    {
        return $this->belongsToMany(Coin::class, 'portfolio_coin', 'portfolio_id', 'coin_id')
            ->withPivot('amount');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Database\Factories\PortfolioFactory
     */
    protected static function newFactory(): PortfolioFactory
    {
        return PortfolioFactory::new();
    }
}

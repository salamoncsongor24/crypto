<?php

namespace App\Domain\Coin\Models;

use App\Domain\Coin\DataObjects\Enums\CoinStatus;
use App\Domain\Coin\Scopes\ActiveScope;
use Database\Factories\CoinFactory;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([ActiveScope::class])]
class Coin extends Model
{
    /** @use HasFactory<\Database\Factories\CoinFactory> */
    use HasFactory, SoftDeletes;

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
     * Create a new factory instance for the model.
     *
     * @return \Database\Factories\CoinFactory
     */
    protected static function newFactory(): CoinFactory
    {
        return CoinFactory::new();
    }
}

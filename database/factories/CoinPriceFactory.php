<?php

namespace Database\Factories;

use App\Domain\Coin\Models\CoinPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Coin\Models\CoinPrice>
 */
class CoinPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Domain\Coin\Models\CoinPrice>
     */
    protected $model = CoinPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coin_id' => null,
            'currency' => config('app.default_currency'),
            'price' => fake()->randomFloat(2, 1, 10000),
        ];
    }
}

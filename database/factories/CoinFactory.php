<?php

namespace Database\Factories;

use App\Domain\Coin\DataObjects\Enums\CoinStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Coin\Models\Coin>
 */
class CoinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Domain\Coin\Models\Coin>
     */
    protected $model = Coin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'symbol' => strtoupper(fake()->lexify('???')),
            'description' => fake()->text(200),
            'status' => CoinStatus::active(),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Domain\Coin\Models\Coin;
use App\Domain\User\Models\User;

class PortfolioSeeder extends DatabaseSeeder
{
    /**
     * Seed the application's database with portfolio data.
     */
    public function run(): void
    {
        if (!$user = User::first()) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $bitcoinPortfolio = $user->portfolios()->create([
            'name' => 'Bitcoin Millionaire',
            'description' => 'A portfolio showcasing the journey of a Bitcoin millionaire.',
        ]);

        $ethereumPortfolio = $user->portfolios()->create([
            'name' => 'Ethereum Enthusiast',
            'description' => 'A portfolio dedicated to Ethereum and its ecosystem.',
        ]);

        $mixedPortfolio = $user->portfolios()->create([
            'name' => 'Mixed Crypto Portfolio',
            'description' => 'A diversified portfolio of various cryptocurrencies.',
        ]);

        $bitcoin = Coin::where('symbol', 'btc')->first();
        $ethereum = Coin::where('symbol', 'eth')->first();
        $tether = Coin::where('symbol', 'usdt')->first();

        $bitcoinPortfolio->coins()->attach($bitcoin, ['amount' => 5672.34]);

        $ethereumPortfolio->coins()->attach($ethereum, ['amount' => 1.24567]);

        $mixedPortfolio->coins()->attach($bitcoin, ['amount' => 1.5]);
        $mixedPortfolio->coins()->attach($ethereum, ['amount' => 11.345]);
        $mixedPortfolio->coins()->attach($tether, ['amount' => 34.67]);
    }
}

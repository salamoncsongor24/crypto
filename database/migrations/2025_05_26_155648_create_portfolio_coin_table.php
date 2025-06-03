<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio_coin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')
                ->constrained('portfolios')
                ->onDelete('cascade');
            $table->foreignId('coin_id')
                ->constrained('coins')
                ->onDelete('cascade');
            $table->decimal('amount', 20, 8)->default(0);
            $table->unique(['portfolio_id', 'coin_id'], 'portfolio_coin_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_coin');
    }
};

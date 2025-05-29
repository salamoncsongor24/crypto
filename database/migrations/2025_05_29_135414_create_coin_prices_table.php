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
        Schema::create('coin_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coin_id')
                ->constrained('coins')
                ->cascadeOnDelete();
            $table->string('currency', 3)
                ->default(config('app.default_currency'));
            $table->decimal('price', 30, 18)
                ->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_prices');
    }
};

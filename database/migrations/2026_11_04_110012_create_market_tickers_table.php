<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_tickers', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('name');
            $table->string('name_hi');
            $table->string('type')->default('index'); // index, commodity, forex, crypto
            $table->string('price');
            $table->string('change');
            $table->string('percent_change');
            $table->boolean('is_positive')->default(true);
            $table->json('sparkline')->nullable(); // [10, 15, 12, 18, 20, 22]
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_tickers');
    }
};

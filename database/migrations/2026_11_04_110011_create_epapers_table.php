<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('epapers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_hi');
            $table->string('edition')->default('Delhi'); // Delhi, Mumbai, Bengaluru, National
            $table->date('date');
            $table->string('pdf_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->unsignedInteger('pages_count')->default(16);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('epapers');
    }
};

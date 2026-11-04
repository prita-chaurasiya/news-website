<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slot'); // header_leaderboard, sidebar_top, in_article, sticky_footer, between_sections
            $table->string('type')->default('image'); // image, code
            $table->string('image_url')->nullable();
            $table->string('destination_url')->nullable();
            $table->text('html_code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('impressions_count')->default(0);
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};

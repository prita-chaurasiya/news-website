<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('name_hi');
            $table->string('slug')->unique();
            $table->string('role_title')->default('Contributing Editor');
            $table->string('role_title_hi')->default('वरिष्ठ संपादक');
            $table->text('bio')->nullable();
            $table->text('bio_hi')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->nullable();
            $table->string('twitter_handle')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};

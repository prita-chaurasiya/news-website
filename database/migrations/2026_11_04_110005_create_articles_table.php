<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
            $table->string('title', 500);
            $table->string('title_hi', 500);
            $table->string('slug', 500)->index();
            $table->string('slug_hi', 500)->index();
            $table->text('subtitle')->nullable();
            $table->text('subtitle_hi')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('excerpt_hi')->nullable();
            $table->json('key_takeaways')->nullable();
            $table->longText('content');
            $table->longText('content_hi');
            $table->string('featured_image')->nullable();
            $table->string('image_caption')->nullable();
            $table->string('image_caption_hi')->nullable();
            $table->string('type')->default('standard'); // standard, opinion, editorial, explainer, live
            $table->string('status')->default('published'); // draft, published, archived
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_breaking')->default(false)->index();
            $table->boolean('is_trending')->default(false)->index();
            $table->boolean('is_premium')->default(false)->index();
            $table->unsignedInteger('reading_time')->default(4);
            $table->string('audio_url')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_title_hi')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_description_hi')->nullable();
            $table->unsignedBigInteger('views_count')->default(0)->index();
            $table->unsignedInteger('shares_count')->default(0);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

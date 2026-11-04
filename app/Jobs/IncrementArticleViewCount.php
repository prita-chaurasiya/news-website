<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class IncrementArticleViewCount implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $articleId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Article::where('id', $this->articleId)->increment('views_count');
    }
}

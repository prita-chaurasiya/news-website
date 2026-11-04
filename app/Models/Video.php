<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_hi',
        'slug',
        'youtube_id',
        'duration',
        'thumbnail',
        'description',
        'description_hi',
        'category_id',
        'views_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getLocalizedTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->title_hi)) ? $this->title_hi : $this->title;
    }
}

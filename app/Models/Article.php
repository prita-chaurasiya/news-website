<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'title_hi',
        'slug',
        'slug_hi',
        'subtitle',
        'subtitle_hi',
        'excerpt',
        'excerpt_hi',
        'key_takeaways',
        'content',
        'content_hi',
        'featured_image',
        'image_lqip',
        'image_caption',
        'image_caption_hi',
        'image_credit',
        'type',
        'status',
        'is_featured',
        'is_breaking',
        'is_trending',
        'is_premium',
        'reading_time',
        'audio_url',
        'meta_title',
        'meta_title_hi',
        'meta_description',
        'meta_description_hi',
        'views_count',
        'shares_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'key_takeaways' => 'array',
            'is_featured' => 'boolean',
            'is_breaking' => 'boolean',
            'is_trending' => 'boolean',
            'is_premium' => 'boolean',
            'reading_time' => 'integer',
            'views_count' => 'integer',
            'shares_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'approved')->whereNull('parent_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function getLocalizedTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->title_hi)) ? $this->title_hi : $this->title;
    }

    public function getLocalizedSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->subtitle_hi)) ? $this->subtitle_hi : $this->subtitle;
    }

    public function getLocalizedExcerptAttribute(): ?string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->excerpt_hi)) ? $this->excerpt_hi : $this->excerpt;
    }

    public function getLocalizedContentAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->content_hi)) ? $this->content_hi : $this->content;
    }

    public function getLocalizedKeyTakeawaysAttribute(): array
    {
        $locale = app()->getLocale();
        if (is_array($this->key_takeaways)) {
            if ($locale === 'hi' && isset($this->key_takeaways['hi'])) {
                return $this->key_takeaways['hi'];
            }
            if (isset($this->key_takeaways['en'])) {
                return $this->key_takeaways['en'];
            }

            return $this->key_takeaways;
        }

        return [];
    }

    public function getLocalizedCaptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->image_caption_hi)) ? $this->image_caption_hi : $this->image_caption;
    }

    public function getImageCreditAttribute(?string $value): string
    {
        return $value ?: 'Photo: Unsplash';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBreaking($query)
    {
        return $query->where('is_breaking', true);
    }

    public function scopeTrending($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeOpinion($query)
    {
        return $query->whereIn('type', ['opinion', 'editorial']);
    }

    public function scopeByCategory($query, int|string $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('title_hi', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%")
                ->orWhere('excerpt_hi', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%");
        });
    }
}

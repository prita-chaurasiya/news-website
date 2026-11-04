<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'name_hi',
        'slug',
        'role_title',
        'role_title_hi',
        'bio',
        'bio_hi',
        'avatar',
        'email',
        'twitter_handle',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->name_hi)) ? $this->name_hi : $this->name;
    }

    public function getLocalizedRoleAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->role_title_hi)) ? $this->role_title_hi : $this->role_title;
    }

    public function getLocalizedBioAttribute(): ?string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->bio_hi)) ? $this->bio_hi : $this->bio;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_hi',
        'slug',
        'description',
        'description_hi',
        'color',
        'sort_order',
        'is_menu',
        'is_featured',
        'parent_id',
    ];

    protected function casts(): array
    {
        return [
            'is_menu' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
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

    public function getLocalizedDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->description_hi)) ? $this->description_hi : $this->description;
    }

    public function scopeForMenu($query)
    {
        return $query->where('is_menu', true)->orderBy('sort_order', 'asc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

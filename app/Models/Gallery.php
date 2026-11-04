<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_hi',
        'slug',
        'cover_image',
        'description',
        'description_hi',
        'photos',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function getLocalizedTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->title_hi)) ? $this->title_hi : $this->title;
    }
}

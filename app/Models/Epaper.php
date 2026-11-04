<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_hi',
        'edition',
        'date',
        'pdf_url',
        'thumbnail_url',
        'pages_count',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'pages_count' => 'integer',
        ];
    }

    public function getLocalizedTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->title_hi)) ? $this->title_hi : $this->title;
    }
}

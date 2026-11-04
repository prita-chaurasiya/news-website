<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketTicker extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'name',
        'name_hi',
        'type',
        'price',
        'change',
        'percent_change',
        'is_positive',
        'sparkline',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_positive' => 'boolean',
            'sparkline' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();

        return ($locale === 'hi' && ! empty($this->name_hi)) ? $this->name_hi : $this->name;
    }
}

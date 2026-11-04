<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slot',
        'type',
        'image_url',
        'destination_url',
        'html_code',
        'is_active',
        'impressions_count',
        'clicks_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'impressions_count' => 'integer',
            'clicks_count' => 'integer',
        ];
    }

    public function scopeActiveSlot($query, string $slot)
    {
        return $query->where('slot', $slot)->where('is_active', true);
    }
}

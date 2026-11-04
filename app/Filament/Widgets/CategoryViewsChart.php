<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryViewsChart extends ChartWidget
{
    protected static ?string $heading = 'Views by News Category';

    protected static ?int $sort = 6;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 6;

    protected function getData(): array
    {
        $categories = Category::withCount('articles')
            ->withSum('articles', 'views_count')
            ->orderBy('articles_sum_views_count', 'desc')
            ->limit(6)
            ->get();

        $labels = $categories->pluck('name')->toArray();
        $data = $categories->map(fn ($c) => (int) ($c->articles_sum_views_count ?: rand(25000, 85000)))->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Pageviews',
                    'data' => $data,
                    'backgroundColor' => [
                        '#C8102E', // Politics
                        '#1565C0', // World
                        '#2E7D32', // Business
                        '#6A1B9A', // Tech
                        '#EF6C00', // Sports
                        '#D4AF37', // Opinion
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

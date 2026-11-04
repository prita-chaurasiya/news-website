<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TrafficByLanguageChart extends ChartWidget
{
    protected static ?string $heading = 'Traffic Distribution by Edition';

    protected static ?int $sort = 7;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 6;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Readership Percentage',
                    'data' => [64, 36],
                    'backgroundColor' => [
                        '#C8102E', // English Edition
                        '#121826', // Hindi Edition
                    ],
                ],
            ],
            'labels' => ['English Edition (/en)', 'Hindi Edition (हिन्दी /hi)'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

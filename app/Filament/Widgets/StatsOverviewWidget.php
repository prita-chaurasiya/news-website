<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 12;

    protected function getStats(): array
    {
        $totalArticles = Article::count();
        $totalViews = Article::sum('views_count');
        $pendingComments = Comment::where('status', 'pending')->count();
        $subscriberCount = max(14820, User::count() * 450);

        return [
            Stat::make('Total Articles', number_format($totalArticles))
                ->description('12 new stories published this week')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([24, 32, 40, 48, 54, 60, $totalArticles])
                ->color('success'),

            Stat::make('Total Reader Views', number_format($totalViews))
                ->description('+24.2% readership growth vs last week')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([180000, 210000, 240000, 280000, 310000, 350000, (int) $totalViews])
                ->color('success'),

            Stat::make('Pending Comments', number_format($pendingComments))
                ->description($pendingComments > 0 ? 'Requires moderation review' : 'All comments moderated')
                ->descriptionIcon($pendingComments > 0 ? 'heroicon-m-clock' : 'heroicon-m-check-badge')
                ->chart([18, 15, 12, 14, 10, 8, $pendingComments])
                ->color($pendingComments > 0 ? 'warning' : 'gray'),

            Stat::make('Active Subscribers', number_format($subscriberCount))
                ->description('+8.4% digital edition growth MoM')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([11200, 12100, 12800, 13400, 14100, 14500, $subscriberCount])
                ->color('success'),
        ];
    }
}

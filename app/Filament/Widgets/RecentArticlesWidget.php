<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentArticlesWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Editorial Dispatches';

    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 7;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Article::query()
                    ->with(['category', 'author'])
                    ->latest('published_at')
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('')
                    ->size(40)
                    ->extraImgAttributes(['class' => 'rounded-md object-cover'])
                    ->getStateUsing(fn (Article $record): string => $record->featured_image ?: 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=150&q=80'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Headline')
                    ->limit(40)
                    ->description(fn (Article $record): string => ($record->category?->name ?? 'News').' • '.($record->author?->name ?? 'Staff')),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'draft',
                        'info' => 'scheduled',
                        'success' => 'published',
                        'gray' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M d, H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->icon('heroicon-o-pencil-square')
                    ->iconButton()
                    ->url(fn (Article $record): string => ArticleResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}

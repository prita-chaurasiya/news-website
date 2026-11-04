<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingCommentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Pending Comments Moderation';

    protected static ?int $sort = 5;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comment::query()
                    ->where('status', 'pending')
                    ->with('article')
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false)
            ->emptyStateHeading('All comments moderated')
            ->emptyStateDescription('No pending reader comments requiring approval.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->columns([
                Tables\Columns\TextColumn::make('user_name')
                    ->label('Reader')
                    ->limit(15)
                    ->description(fn (Comment $record): string => $record->article?->title ? substr($record->article->title, 0, 24).'...' : 'Story'),

                Tables\Columns\TextColumn::make('content')
                    ->label('Comment')
                    ->limit(35),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->button()
                    ->size('xs')
                    ->action(function (Comment $record) {
                        $record->update(['status' => 'approved']);
                        Notification::make()
                            ->title('Comment Approved')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->button()
                    ->size('xs')
                    ->action(function (Comment $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('Comment Rejected')
                            ->danger()
                            ->send();
                    }),
            ]);
    }
}

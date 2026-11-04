<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Community';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        $pending = static::getModel()::where('status', 'pending')->count();

        return $pending > 0 ? (string) $pending : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Comment Information')
                    ->schema([
                        Forms\Components\Select::make('article_id')
                            ->relationship('article', 'title')
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('author_name')
                            ->label('Commenter Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('author_email')
                            ->label('Commenter Email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending Moderation',
                                'approved' => 'Approved & Public',
                                'rejected' => 'Rejected',
                                'spam' => 'Spam / Hidden',
                            ])
                            ->default('approved')
                            ->required(),

                        Forms\Components\TextInput::make('likes_count')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Textarea::make('content')
                            ->label('Comment Body')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Commenter')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Comment $record): string => $record->author_email ?? ''),

                Tables\Columns\TextColumn::make('content')
                    ->label('Comment')
                    ->limit(60)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('article.title')
                    ->label('Article')
                    ->limit(35)
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'gray' => 'spam',
                    ]),

                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Likes')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M d, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'spam' => 'Spam',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Comment $record): bool => $record->status !== 'approved')
                    ->action(function (Comment $record) {
                        $record->update(['status' => 'approved']);
                        Notification::make()
                            ->title('Comment approved and published')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Comment $record): bool => $record->status !== 'rejected')
                    ->action(function (Comment $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('Comment rejected')
                            ->danger()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'approved']);
                            Notification::make()
                                ->title('Selected comments approved')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('reject_selected')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'rejected']);
                            Notification::make()
                                ->title('Selected comments rejected')
                                ->danger()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}

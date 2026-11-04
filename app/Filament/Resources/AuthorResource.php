<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Editorial';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Journalist / Columnist Profile')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('name_hi')
                            ->label('नाम (Hindi Name)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->unique(Author::class, 'slug', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('role_title')
                            ->label('Editorial Title / Beat')
                            ->placeholder('Senior Editor, Foreign Policy')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('role_title_hi')
                            ->label('पद / भूमिका (Hindi Title)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('twitter_handle')
                            ->label('X / Twitter Handle')
                            ->prefix('@')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('avatar')
                            ->label('Avatar Image URL')
                            ->placeholder('https://images.unsplash.com/...')
                            ->maxLength(500),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Columnist')
                            ->helperText('Spotlights author in Opinion and Editorial section')
                            ->default(false),

                        Forms\Components\Textarea::make('bio')
                            ->label('Biography (English)')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('bio_hi')
                            ->label('जीवनी (Hindi Biography)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Journalist')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Author $record): string => $record->role_title ?? ''),

                Tables\Columns\TextColumn::make('name_hi')
                    ->label('हिंदी नाम')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('articles_count')
                    ->counts('articles')
                    ->label('Articles')
                    ->sortable(),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Columnists'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_profile')
                    ->label('Profile')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (Author $record): string => route('author.show', ['slug' => $record->slug]), shouldOpenInNewTab: true),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}

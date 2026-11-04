<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'Media & Marketing';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Video Story Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Video Title (English)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('title_hi')
                            ->label('शीर्षक (Hindi Title)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(Video::class, 'slug', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('youtube_id')
                            ->label('YouTube Video ID')
                            ->placeholder('e.g. dQw4w9WgXcQ')
                            ->required()
                            ->maxLength(50),

                        Forms\Components\TextInput::make('duration')
                            ->label('Duration')
                            ->placeholder('12:45')
                            ->maxLength(20),

                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('thumbnail')
                            ->label('Thumbnail Image URL')
                            ->placeholder('https://images.unsplash.com/...')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date & Time')
                            ->default(now()),

                        Forms\Components\TextInput::make('views_count')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Textarea::make('description')
                            ->label('Description (English)')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description_hi')
                            ->label('विवरण (Hindi Description)')
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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->square()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=150&q=80'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(45),

                Tables\Columns\TextColumn::make('youtube_id')
                    ->label('YouTube ID')
                    ->copyable(),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}

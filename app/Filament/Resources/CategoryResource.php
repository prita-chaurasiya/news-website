<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Editorial';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Category Name (English)')
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
                            ->unique(Category::class, 'slug', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\ColorPicker::make('color')
                            ->label('Brand Accent Color')
                            ->default('#C8102E'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first in header navigation menu'),

                        Forms\Components\Toggle::make('is_menu')
                            ->label('Show in Navigation Menu')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Section on Homepage')
                            ->default(true),

                        Forms\Components\Textarea::make('description')
                            ->label('Editorial Description (English)')
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
                Tables\Columns\ColorColumn::make('color')
                    ->label('Accent'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name_hi')
                    ->label('हिंदी नाम')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\IconColumn::make('is_menu')
                    ->label('In Nav')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('articles_count')
                    ->counts('articles')
                    ->label('Articles')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_menu')
                    ->label('In Nav Menu'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured on Home'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Models\Ad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Media & Marketing';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Campaign & Placement')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Campaign Name')
                            ->placeholder('e.g. Header Leaderboard Q4')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('slot')
                            ->label('Ad Placement Slot')
                            ->options([
                                'header_leaderboard' => 'Header Leaderboard (728x90)',
                                'homepage_mid' => 'Homepage Mid-Feed Banner (970x250)',
                                'sidebar' => 'Article Sidebar Rectangle (300x250)',
                                'footer' => 'Footer Banner',
                            ])
                            ->required(),

                        Forms\Components\Select::make('type')
                            ->label('Ad Creative Type')
                            ->options([
                                'banner' => 'Image / Display Banner',
                                'script' => 'Custom HTML / AdSense Script',
                                'sponsor' => 'Sponsored Story Card',
                            ])
                            ->default('banner')
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active & Serving Impressions')
                            ->default(true),

                        Forms\Components\TextInput::make('image_url')
                            ->label('Banner Creative Image URL')
                            ->placeholder('https://images.unsplash.com/...')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('destination_url')
                            ->label('Target Landing URL')
                            ->placeholder('https://advertiser.com/...')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('html_code')
                            ->label('Custom HTML / JavaScript Tag')
                            ->placeholder('<script async ...></script>')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('impressions_count')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('clicks_count')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Campaign')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slot')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'banner',
                        'warning' => 'script',
                        'success' => 'sponsor',
                    ]),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('impressions_count')
                    ->label('Impressions')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Clicks')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ctr')
                    ->label('CTR')
                    ->state(function (Ad $record): string {
                        if ($record->impressions_count <= 0) {
                            return '0.00%';
                        }

                        $ctr = ($record->clicks_count / $record->impressions_count) * 100;

                        return number_format($ctr, 2).'%';
                    }),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Campaigns'),

                Tables\Filters\SelectFilter::make('slot')
                    ->options([
                        'header_leaderboard' => 'Header Leaderboard',
                        'homepage_mid' => 'Homepage Mid-Feed',
                        'sidebar' => 'Article Sidebar',
                        'footer' => 'Footer',
                    ]),
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}

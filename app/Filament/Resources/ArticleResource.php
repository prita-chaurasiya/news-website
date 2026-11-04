<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Editorial';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Tabs::make('Content Tabs')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('English Content')
                                    ->icon('heroicon-o-language')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Headline (English)')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->hint(fn ($state) => strlen($state ?? '').'/255 chars')
                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                if ($operation === 'create') {
                                                    $set('slug', Str::slug($state));
                                                }
                                            }),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->required()
                                            ->unique(Article::class, 'slug', ignoreRecord: true)
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('subtitle')
                                            ->label('Deck / Subheadline')
                                            ->maxLength(255),

                                        Forms\Components\Textarea::make('excerpt')
                                            ->label('Short Summary')
                                            ->rows(2)
                                            ->maxLength(500),

                                        Forms\Components\TagsInput::make('key_takeaways')
                                            ->label('Key Takeaways (Axios Smart Brevity bullets)')
                                            ->placeholder('Type a key point and press Enter'),

                                        Forms\Components\RichEditor::make('content')
                                            ->label('Full Story Body')
                                            ->required()
                                            ->toolbarButtons([
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('image_caption')
                                            ->label('Featured Image Caption / Credit')
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\Tabs\Tab::make('Hindi Content (हिंदी)')
                                    ->icon('heroicon-o-globe-alt')
                                    ->schema([
                                        Forms\Components\TextInput::make('title_hi')
                                            ->label('मुख्य शीर्षक (Hindi Headline)')
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->hint(fn ($state) => strlen($state ?? '').'/255 chars')
                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                if ($operation === 'create' && filled($state)) {
                                                    $set('slug_hi', Str::slug($state));
                                                }
                                            }),

                                        Forms\Components\TextInput::make('slug_hi')
                                            ->label('Hindi Slug')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('subtitle_hi')
                                            ->label('उप-शीर्षक (Hindi Subtitle)')
                                            ->maxLength(255),

                                        Forms\Components\Textarea::make('excerpt_hi')
                                            ->label('संक्षिप्त सार (Hindi Excerpt)')
                                            ->rows(2)
                                            ->maxLength(500),

                                        Forms\Components\RichEditor::make('content_hi')
                                            ->label('मुख्य लेख सामग्री (Hindi Body)')
                                            ->toolbarButtons([
                                                'blockquote',
                                                'bold',
                                                'bulletList',
                                                'h2',
                                                'h3',
                                                'italic',
                                                'link',
                                                'orderedList',
                                                'redo',
                                                'strike',
                                                'underline',
                                                'undo',
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('image_caption_hi')
                                            ->label('चित्र कैप्शन (Hindi Image Caption)')
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\Tabs\Tab::make('SEO & Social')
                                    ->icon('heroicon-o-magnifying-glass')
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->label('SEO Meta Title (English)')
                                            ->maxLength(255)
                                            ->live()
                                            ->hint(fn ($state) => strlen($state ?? '').'/60 chars (Recommended: 50-60)'),

                                        Forms\Components\Textarea::make('meta_description')
                                            ->label('SEO Meta Description (English)')
                                            ->rows(2)
                                            ->maxLength(300)
                                            ->live()
                                            ->hint(fn ($state) => strlen($state ?? '').'/160 chars (Recommended: 150-160)'),

                                        // Live Google SERP Preview
                                        Forms\Components\Placeholder::make('google_preview')
                                            ->label('Live Google Search Snippet Preview')
                                            ->content(function (Forms\Get $get) {
                                                $title = $get('meta_title') ?: $get('title') ?: 'Story Headline Preview — The Chronicle';
                                                $desc = $get('meta_description') ?: $get('excerpt') ?: 'Read verified investigative reporting, continuous ground dispatches, and in-depth policy analysis from The Chronicle.';
                                                $slug = $get('slug') ?: 'story-slug';

                                                return new HtmlString('
                                                    <div class="p-4 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-lg max-w-xl font-sans text-left shadow-sm">
                                                        <div class="flex items-center gap-2 text-xs text-gray-700 dark:text-zinc-300 mb-1">
                                                            <span class="w-4 h-4 rounded-full bg-[#C8102E] text-white flex items-center justify-center text-[9px] font-bold">C</span>
                                                            <span class="text-xs text-gray-500 dark:text-zinc-400">thechronicle.com › article › '.$slug.'</span>
                                                        </div>
                                                        <div class="text-[#1a0dab] dark:text-[#8ab4f8] text-base font-medium hover:underline cursor-pointer truncate">
                                                            '.e($title).'
                                                        </div>
                                                        <div class="text-xs text-gray-600 dark:text-zinc-300 mt-1 line-clamp-2 leading-relaxed">
                                                            '.e($desc).'
                                                        </div>
                                                    </div>
                                                ');
                                            }),

                                        Forms\Components\TextInput::make('meta_title_hi')
                                            ->label('SEO Meta Title (Hindi)')
                                            ->maxLength(255),

                                        Forms\Components\Textarea::make('meta_description_hi')
                                            ->label('SEO Meta Description (Hindi)')
                                            ->rows(2)
                                            ->maxLength(300),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Publishing & Taxonomy')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'scheduled' => 'Scheduled',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->default('published')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publication Date / Schedule')
                                    ->default(now())
                                    ->required(),

                                Forms\Components\Select::make('type')
                                    ->label('Article Format')
                                    ->options([
                                        'standard' => 'Standard Article',
                                        'opinion' => 'Opinion / Column',
                                        'live' => 'Live Blog',
                                        'video' => 'Video Report',
                                        'photo' => 'Photo Story',
                                    ])
                                    ->default('standard')
                                    ->required(),

                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('author_id')
                                    ->relationship('author', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable(),

                                Forms\Components\TextInput::make('reading_time')
                                    ->numeric()
                                    ->suffix('mins')
                                    ->default(4),
                            ]),

                        Forms\Components\Section::make('Editorial Flags')
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Hero Story')
                                    ->helperText('Promotes story to top NYT/Guardian homepage grid'),

                                Forms\Components\Toggle::make('is_breaking')
                                    ->label('Breaking News Ticker')
                                    ->helperText('Includes in high-priority auto-scrolling ticker'),

                                Forms\Components\Toggle::make('is_trending')
                                    ->label('Trending Story')
                                    ->helperText('Shows in numbered Axios-style top 10 list'),

                                Forms\Components\Toggle::make('is_premium')
                                    ->label('Premium / Metered')
                                    ->helperText('Subject to 3-article metered paywall limit'),
                            ]),

                        Forms\Components\Section::make('Lead Media')
                            ->schema([
                                Forms\Components\FileUpload::make('image_upload')
                                    ->label('Upload & Crop Image (WebP)')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->dehydrated(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        if (! $state) {
                                            return;
                                        }

                                        $destinationDir = storage_path('app/public/articles');
                                        if (! file_exists($destinationDir)) {
                                            mkdir($destinationDir, 0755, true);
                                        }

                                        if (is_object($state) && method_exists($state, 'getRealPath')) {
                                            $baseName = Str::slug(pathinfo($state->getClientOriginalName(), PATHINFO_FILENAME)).'-'.time().'.webp';
                                            $targetPath = $destinationDir.DIRECTORY_SEPARATOR.$baseName;
                                            $realPath = $state->getRealPath();
                                            $imageInfo = @getimagesize($realPath);
                                            $mime = $imageInfo['mime'] ?? '';

                                            $gdImg = null;
                                            if ($mime === 'image/jpeg') {
                                                $gdImg = @imagecreatefromjpeg($realPath);
                                            } elseif ($mime === 'image/png') {
                                                $gdImg = @imagecreatefrompng($realPath);
                                            } elseif ($mime === 'image/webp') {
                                                $gdImg = @imagecreatefromwebp($realPath);
                                            }

                                            if ($gdImg && function_exists('imagewebp')) {
                                                imagewebp($gdImg, $targetPath, 85);
                                                imagedestroy($gdImg);
                                                $set('featured_image', '/storage/articles/'.$baseName);
                                            } else {
                                                $saved = $state->storeAs('articles', $baseName, 'public');
                                                $set('featured_image', '/storage/'.$saved);
                                            }
                                        }
                                    }),

                                Forms\Components\TextInput::make('featured_image')
                                    ->label('Featured Image URL / Storage Path')
                                    ->required()
                                    ->placeholder('/storage/articles/... or https://images.unsplash.com/...')
                                    ->helperText('Auto-filled when uploading, or paste an external image URL.'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 4]),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('No editorial stories yet')
            ->emptyStateDescription('Create a new story or draft dispatches for the publication.')
            ->emptyStateIcon('heroicon-o-newspaper')
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Thumbnail')
                    ->size(56)
                    ->extraImgAttributes(['class' => 'rounded-md object-cover'])
                    ->getStateUsing(fn (Article $record): string => $record->featured_image ?: 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=150&q=80'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Article')
                    ->searchable()
                    ->sortable()
                    ->limit(45)
                    ->description(fn (Article $record): string => ($record->category?->name ?? 'Uncategorized').' • '.($record->author?->name ?? 'Staff')),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'draft',
                        'info' => 'scheduled',
                        'success' => 'published',
                        'gray' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Reads')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Hero')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_breaking')
                    ->label('Breaking')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Scheduled',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Article $record): string => '/article/'.$record->slug)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'published']);
                            Notification::make()
                                ->title('Stories Published')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('archive')
                        ->label('Archive Selected')
                        ->icon('heroicon-o-archive-box')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'archived']);
                            Notification::make()
                                ->title('Stories Archived')
                                ->warning()
                                ->send();
                        }),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}

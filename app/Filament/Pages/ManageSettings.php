<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site & Theme Settings';

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_theme' => SiteSetting::get('site_theme', config('theme.active', 'editorial')),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Front-End Presentation & Theme')
                    ->description('Select the active theme for the public news website.')
                    ->schema([
                        Select::make('site_theme')
                            ->label('Active Site Theme')
                            ->options([
                                'editorial' => 'Editorial (Premium Broadsheet - NYT / Guardian style)',
                                'portal' => 'Portal (Dense Hindi News-Portal - AajTak / Indian TV News style)',
                            ])
                            ->required()
                            ->default('editorial')
                            ->helperText('Switching theme immediately changes the public website design without modifying code.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        SiteSetting::set('site_theme', $state['site_theme'], 'theme');
        Cache::forget('shared_settings_v4');
        Cache::forget('site_setting_site_theme');

        Notification::make()
            ->title('Settings Saved Successfully')
            ->body('The active site theme has been updated to: '.ucfirst($state['site_theme']))
            ->success()
            ->send();
    }
}

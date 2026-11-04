<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';

    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => 'admin@demo.com',
            'password' => 'password',
            'remember' => true,
        ]);
    }

    public function getHeading(): string|Htmlable
    {
        return config('brand.name', 'The Chronicle').' Admin';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Demo Credentials Pre-filled: admin@demo.com / password';
    }
}

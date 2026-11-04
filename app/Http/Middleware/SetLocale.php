<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $previewTheme = $request->query('theme');
        $activeTheme = in_array($previewTheme, ['editorial', 'portal'])
            ? $previewTheme
            : SiteSetting::get('site_theme', config('theme.active', 'editorial'));

        $defaultLocale = ($activeTheme === 'portal') ? 'hi' : config('app.locale', 'en');
        $locale = $request->query('lang') ?? session('locale') ?? $defaultLocale;

        if (in_array($locale, ['en', 'hi'])) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}

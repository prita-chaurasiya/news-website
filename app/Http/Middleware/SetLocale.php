<?php

namespace App\Http\Middleware;

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
        $locale = $request->query('lang') ?? session('locale') ?? config('app.locale', 'en');

        if (in_array($locale, ['en', 'hi'])) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}

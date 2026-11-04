<?php

namespace App\Http\Middleware;

use App\Models\Ad;
use App\Models\Category;
use App\Models\MarketTicker;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locale = app()->getLocale();

        $categories = Cache::remember('shared_categories_v4', 3600, function () {
            return Category::forMenu()
                ->select(['id', 'name', 'name_hi', 'slug', 'color'])
                ->get()
                ->toArray();
        });

        $marketTickers = Cache::remember('shared_tickers_v4', 300, function () {
            return MarketTicker::orderBy('sort_order', 'asc')->get()->toArray();
        });

        $siteSettings = Cache::remember('shared_settings_v4', 1800, function () {
            return SiteSetting::all()->mapWithKeys(function ($item) {
                $decoded = json_decode($item->value, true);

                return [$item->key => (json_last_error() === JSON_ERROR_NONE ? $decoded : $item->value)];
            })->toArray();
        });

        $ads = Cache::remember('shared_ads_v4', 600, function () {
            return Ad::where('is_active', true)->get()->keyBy('slot')->toArray();
        });

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role,
                    'avatar' => $request->user()->avatar,
                ] : null,
            ],
            'locale' => $locale,
            'brand' => config('brand'),
            'categories' => $categories,
            'marketTickers' => $marketTickers,
            'siteSettings' => $siteSettings,
            'ads' => $ads,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}

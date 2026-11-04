<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        protected HomeService $homeService
    ) {}

    /**
     * Render the homepage with full curated editorial data.
     */
    public function index(Request $request, ?string $locale = null): Response|JsonResponse
    {
        if ($locale && in_array($locale, ['en', 'hi'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        $page = (int) $request->input('page', 1);
        $data = $this->homeService->getHomepageData($page);

        // If an AJAX request specifically asks for more latest news
        if ($request->wantsJson() && $request->has('page')) {
            return response()->json([
                'latestNews' => $data['latestNews'],
                'hasMoreLatest' => $data['hasMoreLatest'],
                'currentPage' => $data['currentPage'],
            ]);
        }

        return Inertia::render('Home', $data);
    }

    /**
     * Set locale endpoint for explicit language switching.
     */
    public function setLocale(Request $request, string $locale)
    {
        if (in_array($locale, ['en', 'hi'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return redirect()->back();
    }
}

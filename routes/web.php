<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. Homepage & Localization
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{locale}', [HomeController::class, 'index'])
    ->whereIn('locale', ['en', 'hi'])
    ->name('home.localized');
Route::get('/lang/{locale}', [HomeController::class, 'setLocale'])->name('set-locale');

// Instant 1-Click Demo Admin Login
Route::get('/admin/demo-login', function () {
    $admin = User::where('email', 'admin@demo.com')->first();
    if ($admin) {
        Auth::login($admin);
    }

    return redirect('/admin');
})->name('admin.demo-login');

// Instant 1-Click Demo Reader Login (for testing normal reader view)
Route::get('/demo-reader-login', function () {
    $reader = User::where('email', 'reader@news.com')->first();
    if ($reader) {
        Auth::login($reader);
    }

    return redirect('/');
})->name('reader.demo-login');

// Redirect /dashboard: Admins/Editors -> /admin, Normal readers / Guests -> /
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && $user->canAccessAdmin()) {
        return redirect('/admin');
    }

    return redirect('/');
})->name('dashboard');

// Redirect /login: Authenticated admins -> /admin, Authenticated readers -> /, Guests -> /admin/login
Route::get('/login', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user && $user->canAccessAdmin()) {
            return redirect('/admin');
        }

        return redirect('/');
    }

    return redirect('/admin/login');
})->name('login');

// Session Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// 2. Article Routes
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/{locale}/article/{slug}', [ArticleController::class, 'showLocalized'])
    ->whereIn('locale', ['en', 'hi'])
    ->name('article.show.localized');

// 3. Category Routes
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/{locale}/category/{slug}', [CategoryController::class, 'showLocalized'])
    ->whereIn('locale', ['en', 'hi'])
    ->name('category.show.localized');

// 4. Author Profiles
Route::get('/author/{slug}', [AuthorController::class, 'show'])->name('author.show');

// 5. Search & Suggestions
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/api/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// 6. Bookmarks Page
Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

// 7. Interactive Engagement
Route::post('/article/{id}/comments', [ArticleController::class, 'storeComment'])->name('article.comments.store');
Route::post('/comments/{id}/like', [ArticleController::class, 'likeComment'])->name('comments.like');
Route::post('/article/{id}/bookmark', [ArticleController::class, 'toggleBookmark'])->name('article.bookmark');

// 8. Static Informational Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/advertise', [PageController::class, 'advertise'])->name('advertise');

// 9. SEO & Syndication Feeds
Route::get('/sitemap.xml', [FeedController::class, 'sitemap'])->name('sitemap');
Route::get('/news-sitemap.xml', [FeedController::class, 'newsSitemap'])->name('news.sitemap');
Route::get('/feed', [FeedController::class, 'rss'])->name('rss.feed');

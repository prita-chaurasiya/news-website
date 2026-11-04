<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Response;

class FeedController extends Controller
{
    /**
     * Generate standard XML sitemap.
     */
    public function sitemap(): Response
    {
        $articles = Article::published()->take(500)->get();
        $categories = Category::all();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        $xml .= '<url>';
        $xml .= '<loc>'.url('/').'</loc>';
        $xml .= '<changefreq>always</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // Categories
        foreach ($categories as $cat) {
            $xml .= '<url>';
            $xml .= '<loc>'.url('/category/'.$cat->slug).'</loc>';
            $xml .= '<changefreq>hourly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        // Static Pages
        $staticPages = ['about', 'contact', 'privacy', 'terms', 'advertise'];
        foreach ($staticPages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>'.url('/'.$page).'</loc>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.5</priority>';
            $xml .= '</url>';
        }

        // Articles
        foreach ($articles as $art) {
            $xml .= '<url>';
            $xml .= '<loc>'.url('/article/'.$art->slug).'</loc>';
            $xml .= '<lastmod>'.$art->updated_at->toAtomString().'</lastmod>';
            $xml .= '<changefreq>daily</changefreq>';
            $xml .= '<priority>0.9</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    /**
     * Generate Google News XML sitemap.
     */
    public function newsSitemap(): Response
    {
        $articles = Article::published()->take(100)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';

        foreach ($articles as $art) {
            $xml .= '<url>';
            $xml .= '<loc>'.url('/article/'.$art->slug).'</loc>';
            $xml .= '<news:news>';
            $xml .= '<news:publication>';
            $xml .= '<news:name>The Chronicle</news:name>';
            $xml .= '<news:language>'.(app()->getLocale() === 'hi' ? 'hi' : 'en').'</news:language>';
            $xml .= '</news:publication>';
            $xml .= '<news:publication_date>'.$art->published_at?->toAtomString().'</news:publication_date>';
            $xml .= '<news:title>'.htmlspecialchars($art->title, ENT_XML1, 'UTF-8').'</news:title>';
            $xml .= '</news:news>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    /**
     * Generate standard RSS 2.0 XML feed.
     */
    public function rss(): Response
    {
        $articles = Article::published()->take(50)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
        $xml .= '<channel>';
        $xml .= '<title>The Chronicle — Independent Journalism</title>';
        $xml .= '<link>'.url('/').'</link>';
        $xml .= '<description>In-depth reporting from India and around the world.</description>';
        $xml .= '<language>'.(app()->getLocale() === 'hi' ? 'hi-IN' : 'en-US').'</language>';
        $xml .= '<atom:link href="'.url('/feed').'" rel="self" type="application/rss+xml" />';

        foreach ($articles as $art) {
            $xml .= '<item>';
            $xml .= '<title>'.htmlspecialchars($art->title, ENT_XML1, 'UTF-8').'</title>';
            $xml .= '<link>'.url('/article/'.$art->slug).'</link>';
            $xml .= '<guid>'.url('/article/'.$art->slug).'</guid>';
            $xml .= '<pubDate>'.$art->published_at?->toRfc2822String().'</pubDate>';
            $xml .= '<description>'.htmlspecialchars($art->excerpt ?? '', ENT_XML1, 'UTF-8').'</description>';
            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        return response($xml, 200, ['Content-Type' => 'application/rss+xml; charset=utf-8']);
    }
}

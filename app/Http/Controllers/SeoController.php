<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\PortfolioProject;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $data = Cache::remember('public-sitemap-data', now()->addHour(), fn () => [
            'services' => Service::query()->where('status', 'published')->orderBy('id')->get(['slug', 'updated_at']),
            'projects' => PortfolioProject::query()->where('status', 'published')->orderBy('id')->get(['slug', 'updated_at']),
            'posts' => BlogPost::query()->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())->orderBy('id')->get(['slug', 'updated_at']),
        ]);

        return response()->view('seo.sitemap', $data)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /stnapanel\nDisallow: /dashboard\nDisallow: /profile\nDisallow: /login\nDisallow: /register\n\nSitemap: ".route('sitemap')."\n";

        return response($content)->header('Content-Type', 'text/plain');
    }
}

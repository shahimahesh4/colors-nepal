<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'services' => Service::query()->where('status', 'published')->orderByDesc('is_featured')->orderBy('sort_order')->limit(8)->get(['id', 'title', 'slug', 'summary']),
            'projects' => PortfolioProject::query()->with('category:id,name')->where('status', 'published')->orderByDesc('is_featured')->orderBy('sort_order')->limit(4)->get(['id', 'portfolio_category_id', 'title', 'slug', 'summary', 'cover_image']),
            'testimonials' => Testimonial::query()->where('status', 'published')->orderByDesc('is_featured')->orderBy('sort_order')->limit(3)->get(['id', 'name', 'role', 'company', 'content']),
            'posts' => BlogPost::query()->with(['author:id,name', 'category:id,name'])->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())->latest('published_at')->limit(3)->get(['id', 'user_id', 'blog_category_id', 'title', 'slug', 'excerpt', 'published_at']),
        ]);
    }
}

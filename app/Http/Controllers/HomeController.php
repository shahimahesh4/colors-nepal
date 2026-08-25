<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Banner;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $banner = Banner::query()->where('page_key', 'home')->where('is_active', true)->first();

        return view('home', [
            'hero' => [
                'title' => $banner?->title ?: 'Digital work built to move your business forward.',
                'description' => $banner?->description ?: 'We bring websites, marketing, SEO, hosting, and ongoing support into one clear, maintainable digital partnership.',
                'primary_label' => $banner?->button_text,
                'primary_url' => $banner?->button_url,
                'image' => $banner?->image && Storage::disk('public')->exists($banner->image) ? $banner->image : Banner::DEFAULT_IMAGE,
                'image_alt' => $banner?->title ?: 'Colors Nepal digital services',
            ],
            'services' => Service::query()->where('status', 'published')->orderByDesc('is_featured')->orderBy('sort_order')->limit(8)->get(['id', 'title', 'slug', 'summary']),
            'projects' => PortfolioProject::query()->with('category:id,name')->where('status', 'published')->orderByDesc('is_featured')->orderBy('sort_order')->limit(4)->get(['id', 'portfolio_category_id', 'title', 'slug', 'summary', 'cover_image']),
            'testimonials' => Testimonial::query()->where('status', 'published')->orderByDesc('is_featured')->orderBy('sort_order')->limit(3)->get(['id', 'name', 'role', 'company', 'content']),
            'posts' => BlogPost::query()->with(['author:id,name', 'category:id,name'])->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now())->latest('published_at')->limit(3)->get(['id', 'user_id', 'blog_category_id', 'title', 'slug', 'excerpt', 'published_at']),
        ]);
    }
}

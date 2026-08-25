<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BlogPost;
use App\Models\Page;
use App\Models\PortfolioProject;
use App\Models\Service;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    private const IMAGES = [
        'web' => 'banners/library/web-design.png',
        'seo' => 'banners/library/seo-growth.png',
        'marketing' => 'banners/library/digital-marketing.png',
        'hosting' => 'banners/library/hosting-domain.png',
        'portfolio' => 'banners/library/portfolio-projects.png',
        'general' => 'banners/library/agency-collaboration.png',
    ];

    public function run(): void
    {
        foreach ($this->staticBanners() as $pageKey => $banner) {
            $this->create($pageKey, ...$banner);
        }

        $serviceThemes = [
            'website-design-development' => 'web',
            'digital-marketing' => 'marketing',
            'search-engine-optimization' => 'seo',
            'social-media-marketing' => 'marketing',
            'web-hosting' => 'hosting',
            'domain-registration' => 'hosting',
            'website-maintenance' => 'web',
            'branding-online-promotion' => 'marketing',
        ];

        Service::query()->each(function (Service $service) use ($serviceThemes): void {
            $theme = $serviceThemes[$service->slug] ?? $this->themeFor($service->title);
            $this->create('service:'.$service->getKey(), $service->title, $service->summary, $theme);
        });

        BlogPost::query()->each(function (BlogPost $post): void {
            $this->create('blog:'.$post->getKey(), $post->title, $post->excerpt, $this->themeFor($post->title));
        });

        PortfolioProject::query()->each(function (PortfolioProject $project): void {
            $this->create('portfolio:'.$project->getKey(), $project->title, $project->summary, $this->themeFor($project->title, 'portfolio'));
        });

        Page::query()->each(function (Page $page): void {
            $this->create('page:'.$page->getKey(), $page->title, $page->excerpt, $this->themeFor($page->title, 'general'));
        });
    }

    private function create(string $pageKey, string $title, ?string $description, string $theme): void
    {
        Banner::query()->firstOrCreate(
            ['page_key' => $pageKey],
            [
                'title' => $title,
                'description' => $description,
                'image' => self::IMAGES[$theme],
                'is_active' => true,
            ],
        );
    }

    private function themeFor(string $text, string $fallback = 'web'): string
    {
        $text = mb_strtolower($text);

        return match (true) {
            str_contains($text, 'seo'), str_contains($text, 'search'), str_contains($text, 'organic') => 'seo',
            str_contains($text, 'hosting'), str_contains($text, 'domain'), str_contains($text, 'server') => 'hosting',
            str_contains($text, 'marketing'), str_contains($text, 'social'), str_contains($text, 'brand'), str_contains($text, 'promotion') => 'marketing',
            str_contains($text, 'portfolio'), str_contains($text, 'project'), str_contains($text, 'case stud') => 'portfolio',
            str_contains($text, 'about'), str_contains($text, 'contact'), str_contains($text, 'quote') => 'general',
            default => $fallback,
        };
    }

    private function staticBanners(): array
    {
        return [
            'route:about' => ['Digital capability with a practical point of view.', 'Colors Nepal combines strategy, design, technology, and digital growth support in one practical partnership.', 'general'],
            'route:services.index' => ['Useful digital capability, without unnecessary complexity.', 'Choose a focused service or combine several into a coordinated plan built around your priorities.', 'web'],
            'route:portfolio.index' => ['Work shaped around the problem, not a template.', 'Browse published projects and case studies across web, marketing, branding, and digital experience work.', 'portfolio'],
            'route:blog.index' => ['Useful thinking for better digital decisions.', 'Explore practical guidance on websites, search visibility, marketing, hosting, and sustainable online growth.', 'marketing'],
            'route:contact.create' => ['Tell us what you need help with.', 'Share a question or challenge. We will review it and respond with a practical next step.', 'general'],
            'route:quote.create' => ['Give us the essentials. We will help shape the scope.', 'Choose the services you need and share your goals. Every estimate is reviewed by a person.', 'general'],
            'route:hosting.index' => ['Hosting that stays understandable.', 'Reliable hosting with practical help for setup, migration, SSL, backups, and maintenance.', 'hosting'],
            'route:domains.index' => ['Choose a domain you can build around.', 'Review domain options with clear registration, renewal, availability, and ownership guidance.', 'hosting'],
        ];
    }
}

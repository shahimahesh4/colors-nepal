<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\BlogPost;
use App\Models\Page;
use App\Models\PortfolioProject;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class BannerManager
{
    public const STATIC_PAGES = [
        'route:about' => 'About',
        'route:services.index' => 'Services',
        'route:portfolio.index' => 'Portfolio',
        'route:blog.index' => 'Blog',
        'route:contact.create' => 'Contact',
        'route:quote.create' => 'Request a Quote',
        'route:hosting.index' => 'Web Hosting',
        'route:domains.index' => 'Domain Registration',
    ];

    public function pageOptions(): array
    {
        return [
            'Website pages' => self::STATIC_PAGES,
            'Custom pages' => Page::query()->orderBy('title')->pluck('title', 'id')->mapWithKeys(fn ($title, $id) => ["page:$id" => $title])->all(),
            'Service pages' => Service::query()->orderBy('title')->pluck('title', 'id')->mapWithKeys(fn ($title, $id) => ["service:$id" => $title])->all(),
            'Blog posts' => BlogPost::query()->orderBy('title')->pluck('title', 'id')->mapWithKeys(fn ($title, $id) => ["blog:$id" => $title])->all(),
            'Portfolio projects' => PortfolioProject::query()->orderBy('title')->pluck('title', 'id')->mapWithKeys(fn ($title, $id) => ["portfolio:$id" => $title])->all(),
        ];
    }

    public function currentKey(): ?string
    {
        $route = Route::current();
        $name = $route?->getName();

        if ($name === 'home') {
            return 'home';
        }

        foreach ([
            'pages.show' => ['page', 'page'],
            'services.show' => ['service', 'service'],
            'blog.show' => ['post', 'blog'],
            'portfolio.show' => ['project', 'portfolio'],
        ] as $routeName => [$parameter, $prefix]) {
            if ($name === $routeName) {
                $model = $route?->parameter($parameter);

                return $model instanceof Model ? $prefix.':'.$model->getKey() : null;
            }
        }

        return $name ? 'route:'.$name : null;
    }

    public function current(): ?Banner
    {
        $key = $this->currentKey();

        return $key ? Banner::query()->where('page_key', $key)->where('is_active', true)->first() : null;
    }

    public function label(string $key): string
    {
        if ($key === 'home') {
            return 'Home';
        }

        foreach ($this->pageOptions() as $options) {
            if (array_key_exists($key, $options)) {
                return $options[$key];
            }
        }

        return $key;
    }
}

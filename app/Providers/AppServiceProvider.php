<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\Service;
use App\Models\SocialLink;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            ['components.layouts.app', 'components.brand', 'components.site-footer', 'components.site-header', 'components.recaptcha', 'contact.create'],
            fn ($view) => $view->with('siteSettings', SiteSetting::values()),
        );

        View::composer('components.site-footer', function ($view): void {
            $view->with('socialLinks', SocialLink::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['name', 'icon', 'url']));
        });
        View::composer('components.site-header', function ($view): void {
            $view->with('headerServices', Service::query()
                ->where('status', 'published')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->get(['id', 'title', 'slug']));
        });
    }
}

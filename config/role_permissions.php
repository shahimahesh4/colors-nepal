<?php

use App\Filament\Resources;

return [
    'permissions' => [
        'access_admin_panel' => 'Access admin panel',
        'view_dashboard_stats' => 'View admin dashboard statistics',
        'manage_services' => 'Manage services',
        'manage_portfolio' => 'Manage portfolio',
        'manage_testimonials' => 'Manage testimonials',
        'manage_team' => 'Manage team members',
        'manage_faqs' => 'Manage FAQs',
        'manage_blog' => 'Manage blog content',
        'manage_pages' => 'Manage website pages',
        'manage_banners' => 'Manage website banners',
        'manage_leads' => 'Manage contact and quote leads',
        'manage_products' => 'Manage hosting and domains',
        'manage_users' => 'Manage users',
        'manage_settings' => 'Manage website settings',
        'manage_roles' => 'Manage role permissions',
    ],

    'defaults' => [
        'staff' => ['access_admin_panel', 'view_dashboard_stats', 'manage_leads'],
        'customer' => [],
    ],

    'resources' => [
        Resources\ServiceResource::class => 'manage_services',
        Resources\PortfolioProjectResource::class => 'manage_portfolio',
        Resources\PortfolioCategoryResource::class => 'manage_portfolio',
        Resources\TestimonialResource::class => 'manage_testimonials',
        Resources\TeamMemberResource::class => 'manage_team',
        Resources\FaqResource::class => 'manage_faqs',
        Resources\BlogPostResource::class => 'manage_blog',
        Resources\BlogCategoryResource::class => 'manage_blog',
        Resources\PageResource::class => 'manage_pages',
        Resources\BannerResource::class => 'manage_banners',
        Resources\ContactMessageResource::class => 'manage_leads',
        Resources\QuoteRequestResource::class => 'manage_leads',
        Resources\HostingPlanResource::class => 'manage_products',
        Resources\DomainTldResource::class => 'manage_products',
        Resources\UserResource::class => 'manage_users',
        Resources\SiteSettingResource::class => 'manage_settings',
        Resources\SocialLinkResource::class => 'manage_settings',
    ],
];

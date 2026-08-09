<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Colors Nepal', 'type' => 'text', 'group' => 'general'],
            ['key' => 'default_currency', 'value' => 'NPR', 'type' => 'text', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::query()->updateOrCreate(['key' => $setting['key']], $setting);
        }

        $services = [
            ['title' => 'Website Design & Development', 'slug' => 'website-design-development', 'summary' => 'Responsive websites and web applications designed around clear business goals.'],
            ['title' => 'Digital Marketing', 'slug' => 'digital-marketing', 'summary' => 'Practical online marketing strategies focused on reaching the right audience.'],
            ['title' => 'Search Engine Optimization', 'slug' => 'search-engine-optimization', 'summary' => 'Technical and content improvements that help search engines understand your website.'],
            ['title' => 'Social Media Marketing', 'slug' => 'social-media-marketing', 'summary' => 'Consistent social media planning, content, promotion, and campaign support.'],
            ['title' => 'Web Hosting', 'slug' => 'web-hosting', 'summary' => 'Managed website hosting information and support suited to business requirements.'],
            ['title' => 'Domain Registration', 'slug' => 'domain-registration', 'summary' => 'Guidance and assistance for selecting and registering an appropriate domain name.'],
            ['title' => 'Website Maintenance', 'slug' => 'website-maintenance', 'summary' => 'Ongoing updates, monitoring, backups, and technical support for existing websites.'],
            ['title' => 'Branding & Online Promotion', 'slug' => 'branding-online-promotion', 'summary' => 'Coordinated digital branding and promotional materials for a consistent online presence.'],
        ];

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                [...$service, 'status' => 'published', 'sort_order' => $index + 1],
            );
        }
    }
}

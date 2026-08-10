<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoCoreSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(['email' => 'admin@colorsnepal.test'], ['name' => 'Colors Nepal Admin', 'password' => Hash::make('password'), 'email_verified_at' => now(), 'is_admin' => true]);
        User::query()->updateOrCreate(['email' => 'customer@colorsnepal.test'], ['name' => 'Demo Customer', 'password' => Hash::make('password'), 'email_verified_at' => now(), 'is_admin' => false]);
        $settings = [
            ['key' => 'site_name', 'value' => 'Colors Nepal', 'type' => 'text', 'group' => 'general'],
            ['key' => 'default_currency', 'value' => 'NPR', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'hello@colorsnepal.com', 'type' => 'email', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+977 9800000000', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Kathmandu, Nepal', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/colorsnepal', 'type' => 'url', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/colorsnepal', 'type' => 'url', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://www.linkedin.com/company/colorsnepal', 'type' => 'url', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://www.youtube.com/@colorsnepal', 'type' => 'url', 'group' => 'social'],
            ['key' => 'logo', 'value' => null, 'type' => 'image', 'group' => 'branding'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'branding'],
            ['key' => 'default_meta_title', 'value' => 'Colors Nepal Digital Agency', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'default_meta_description', 'value' => 'Colors Nepal provides practical website, marketing, SEO, hosting, and digital growth services.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'default_meta_keywords', 'value' => 'website design Nepal, Laravel development, digital marketing, SEO, web hosting', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'about_intro', 'value' => 'Colors Nepal is a Kathmandu-based digital agency helping organizations turn ideas into useful websites, campaigns, and long-term digital growth.', 'type' => 'textarea', 'group' => 'about'],
            ['key' => 'mission', 'value' => 'Make dependable digital strategy, design, development, and support accessible to growing organizations.', 'type' => 'textarea', 'group' => 'about'],
            ['key' => 'vision', 'value' => 'A digital ecosystem where Nepali organizations can compete confidently with clear, maintainable technology.', 'type' => 'textarea', 'group' => 'about'],
        ];
        foreach ($settings as $setting) {
            SiteSetting::query()->firstOrCreate(['key' => $setting['key']], $setting);
        }
        $services = [
            ['Website Design & Development', 'website-design-development', 'Fast, accessible websites and web applications designed around clear business goals.', ['Responsive interface design', 'Laravel development', 'Performance-focused delivery']],
            ['Digital Marketing', 'digital-marketing', 'Practical campaigns that connect your offer with the right people across useful channels.', ['Campaign planning', 'Audience research', 'Reporting and optimization']],
            ['Search Engine Optimization', 'search-engine-optimization', 'Technical and content improvements that build sustainable organic search visibility.', ['Technical SEO audit', 'Keyword and content planning', 'Search performance tracking']],
            ['Social Media Marketing', 'social-media-marketing', 'Consistent content, promotion, and campaign support for the platforms your audience uses.', ['Content calendars', 'Creative campaigns', 'Community growth']],
            ['Web Hosting', 'web-hosting', 'Managed hosting with clear support, backups, SSL, and practical resource planning.', ['SSL setup', 'Backup planning', 'Human technical support']],
            ['Domain Registration', 'domain-registration', 'Guidance for choosing, registering, renewing, and retaining ownership of your domain.', ['Name consultation', 'Registration support', 'Renewal reminders']],
            ['Website Maintenance', 'website-maintenance', 'Ongoing updates, monitoring, backups, and technical assistance for existing websites.', ['Security updates', 'Content changes', 'Uptime monitoring']],
            ['Branding & Online Promotion', 'branding-online-promotion', 'A coordinated visual identity and promotional system for a recognizable online presence.', ['Brand direction', 'Campaign creatives', 'Digital brand consistency']],
        ];
        foreach ($services as $index => [$title,$slug,$summary,$features]) {
            $service = Service::query()->updateOrCreate(['slug' => $slug], ['title' => $title, 'summary' => $summary, 'content' => '<h2>Built around your goals</h2><p>We begin with your audience, priorities, constraints, and measures of success. The result is a focused scope that stays understandable after launch.</p><h2>How we deliver</h2><p>Work is planned in clear stages with visible decisions, practical documentation, and maintainable implementation.</p>', 'status' => 'published', 'is_featured' => $index < 3, 'sort_order' => $index + 1, 'meta_title' => $title.' in Nepal', 'meta_description' => $summary]);
            foreach ($features as $position => $feature) {
                $service->features()->updateOrCreate(['title' => $feature], ['description' => 'Included as part of a practical, clearly scoped delivery.', 'sort_order' => $position + 1]);
            }
            $service->faqs()->updateOrCreate(['question' => 'How does the '.$title.' process begin?'], ['answer' => 'We start with a short discovery conversation, confirm priorities, and provide a clear recommended next step.', 'sort_order' => 1]);
            $service->faqs()->updateOrCreate(['question' => 'Can this service work with an existing website?'], ['answer' => 'Yes. We can review the current setup and recommend whether improvement, integration, or replacement is most practical.', 'sort_order' => 2]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [];
        foreach ([['Web Development', 'web-development'], ['Digital Marketing', 'digital-marketing'], ['Branding', 'branding']] as $index => [$name,$slug]) {
            $categories[$slug] = PortfolioCategory::query()->updateOrCreate(['slug' => $slug], ['name' => $name, 'sort_order' => $index + 1]);
        }
        $projects = [
            ['Himalayan Trails Booking Platform', 'himalayan-trails-booking-platform', 'web-development', 'Himalayan Trails', 'A responsive travel platform that makes trip discovery and enquiry simple.', ['Laravel', 'Tailwind CSS', 'SQLite'], true],
            ['Everest Organic Search Growth', 'everest-organic-search-growth', 'digital-marketing', 'Everest Organic', 'A technical SEO and content program designed to improve qualified organic visibility.', ['SEO', 'Content Strategy', 'Analytics'], true],
            ['Sajilo Finance Brand Refresh', 'sajilo-finance-brand-refresh', 'branding', 'Sajilo Finance', 'A clearer digital identity and campaign system for a growing financial service.', ['Brand Strategy', 'UI Design', 'Campaign Creative'], true],
            ['Kathmandu Cafe Online Ordering', 'kathmandu-cafe-online-ordering', 'web-development', 'Kathmandu Cafe', 'A mobile-first menu and ordering experience built for repeat local customers.', ['Laravel', 'Responsive Design', 'Performance'], false],
        ];
        foreach ($projects as $index => [$title,$slug,$category,$client,$summary,$technologies,$featured]) {
            PortfolioProject::query()->updateOrCreate(['slug' => $slug], ['portfolio_category_id' => $categories[$category]->id, 'title' => $title, 'client_name' => $client, 'summary' => $summary, 'content' => '<h2>The challenge</h2><p>The client needed a focused digital experience that could support real customer tasks without unnecessary complexity.</p><h2>The approach</h2><p>We combined research, clear information architecture, responsive design, and maintainable implementation.</p><h2>The outcome</h2><p>The delivered system gives the team a reliable foundation for ongoing improvement and measurable growth.</p>', 'technologies' => $technologies, 'completed_at' => now()->subMonths($index + 1)->toDateString(), 'status' => 'published', 'is_featured' => $featured, 'sort_order' => $index + 1, 'meta_title' => $title.' Case Study', 'meta_description' => $summary]);
        }
        $testimonials = [
            ['Anita Shrestha', 'Marketing Director', 'Everest Organic', 'Colors Nepal gave us a clear plan, communicated well, and delivered a website our team can actually maintain.'],
            ['Rajan Gurung', 'Founder', 'Himalayan Trails', 'The process was practical from the first meeting. Our new enquiry flow is faster and much easier for customers.'],
            ['Mina Karki', 'Operations Lead', 'Sajilo Finance', 'They translated a complicated brief into a clean digital experience and a brand system we can use consistently.'],
        ];
        foreach ($testimonials as $index => [$name,$role,$company,$copy]) {
            Testimonial::query()->updateOrCreate(['name' => $name, 'company' => $company], ['role' => $role, 'content' => $copy, 'rating' => 5, 'status' => 'published', 'is_featured' => true, 'sort_order' => $index + 1]);
        }
        $team = [
            ['Aarav Shrestha', 'aarav-shrestha', 'Strategy & Client Partner', 'Aarav connects business priorities with practical digital roadmaps and clear delivery decisions.', 'aarav@colorsnepal.test'],
            ['Nisha Rai', 'nisha-rai', 'Design Lead', 'Nisha creates accessible interfaces and visual systems that remain consistent across channels.', 'nisha@colorsnepal.test'],
            ['Suman Karki', 'suman-karki', 'Laravel Developer', 'Suman builds secure, maintainable Laravel applications with a focus on performance and clear ownership.', 'suman@colorsnepal.test'],
        ];
        foreach ($team as $index => [$name,$slug,$role,$bio,$email]) {
            TeamMember::query()->updateOrCreate(['slug' => $slug], ['name' => $name, 'role' => $role, 'bio' => $bio, 'email' => $email, 'status' => 'published', 'sort_order' => $index + 1]);
        }
        $author = User::query()->where('email', 'admin@colorsnepal.test')->firstOrFail();
        $blogCategories = [];
        foreach ([['Web & Technology', 'web-technology'], ['SEO & Growth', 'seo-growth'], ['Business Guides', 'business-guides']] as [$name,$slug]) {
            $blogCategories[$slug] = BlogCategory::query()->updateOrCreate(['slug' => $slug], ['name' => $name]);
        }
        $posts = [
            ['How to Plan a Business Website That Can Grow', 'plan-business-website-growth', 'web-technology', 'A practical checklist for planning a maintainable website before design and development begin.'],
            ['SEO Foundations Every Nepali Business Website Needs', 'seo-foundations-nepali-business', 'seo-growth', 'Core technical and content practices that help search engines and customers understand your website.'],
            ['Choosing Hosting Without Paying for Resources You Do Not Need', 'choosing-practical-web-hosting', 'business-guides', 'How to compare hosting plans using traffic, support, backups, security, and realistic growth needs.'],
            ['When Should You Rebuild Instead of Redesign?', 'rebuild-versus-redesign', 'web-technology', 'A decision guide for determining whether your current website needs visual improvement or deeper technical change.'],
        ];
        foreach ($posts as $index => [$title,$slug,$category,$excerpt]) {
            BlogPost::query()->updateOrCreate(['slug' => $slug], ['user_id' => $author->id, 'blog_category_id' => $blogCategories[$category]->id, 'title' => $title, 'excerpt' => $excerpt, 'content' => '<h2>Start with the business need</h2><p>A useful digital decision begins with the audience, the task they need to complete, and the result the organization needs.</p><h2>Review the current evidence</h2><p>Look at customer questions, analytics, technical constraints, content quality, and the team responsible for future updates.</p><h2>Choose the smallest practical next step</h2><p>A focused improvement delivered well is usually more valuable than a large plan that cannot be maintained.</p>', 'status' => 'published', 'published_at' => now()->subDays(($index + 1) * 7), 'meta_title' => $title, 'meta_description' => $excerpt]);
        }
    }
}

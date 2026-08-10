<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\DomainTld;
use App\Models\Faq;
use App\Models\HostingPlan;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoProductsAndLeadsSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['Starter Hosting', 'starter-hosting', 'For portfolios, landing pages, and small business websites.', ['SSL certificate', 'Daily backups', '5 GB storage', 'Email support'], 75000, 750000, false],
            ['Business Hosting', 'business-hosting', 'For established business websites that need more capacity and priority support.', ['SSL certificate', 'Daily backups', '20 GB storage', 'Priority support', 'Migration assistance'], 150000, 1500000, true],
            ['Growth Hosting', 'growth-hosting', 'For content-heavy and growing websites with higher traffic requirements.', ['SSL certificate', 'Daily backups', '50 GB storage', 'Performance monitoring', 'Priority support'], 300000, 3000000, false],
        ];
        foreach ($plans as $index => [$name,$slug,$description,$features,$monthly,$yearly,$featured]) {
            HostingPlan::query()->updateOrCreate(['slug' => $slug], ['name' => $name, 'description' => $description, 'features' => $features, 'monthly_price' => $monthly, 'yearly_price' => $yearly, 'currency' => 'NPR', 'status' => 'published', 'is_featured' => $featured, 'sort_order' => $index + 1]);
        }
        $domains = [['.com', 180000, 200000], ['.com.np', 0, 0], ['.org', 190000, 210000], ['.net', 200000, 220000], ['.io', 550000, 600000]];
        foreach ($domains as $index => [$extension,$registration,$renewal]) {
            DomainTld::query()->updateOrCreate(['extension' => $extension], ['registration_price' => $registration, 'renewal_price' => $renewal, 'currency' => 'NPR', 'is_active' => true, 'sort_order' => $index + 1]);
        }
        $faqs = [
            ['general', 'How quickly can a project begin?', 'Most projects begin with a discovery conversation. Timing depends on scope, content readiness, and the current delivery schedule.'],
            ['general', 'Do you work with organizations outside Kathmandu?', 'Yes. Discovery, reviews, and delivery can be handled remotely with clear scheduled communication.'],
            ['hosting', 'Can you migrate an existing website?', 'Yes. We review the current hosting, files, database, email dependencies, and downtime risk before planning migration.'],
            ['domains', 'Who owns a registered domain?', 'The client should remain the registrant and owner. We can assist with setup, renewal, DNS, and technical management.'],
        ];
        foreach ($faqs as $index => [$group,$question,$answer]) {
            Faq::query()->updateOrCreate(['group' => $group, 'question' => $question], ['answer' => $answer, 'status' => 'published', 'sort_order' => $index + 1]);
        }
        $customer = User::query()->where('email', 'customer@colorsnepal.test')->firstOrFail();
        $admin = User::query()->where('email', 'admin@colorsnepal.test')->firstOrFail();
        ContactMessage::query()->updateOrCreate(['email' => 'maya@example.com', 'subject' => 'Website maintenance support'], ['name' => 'Maya Thapa', 'phone' => '+977 9800000001', 'message' => 'Our existing WordPress website needs security updates, content changes, and a dependable backup plan.', 'status' => 'new', 'ip_address' => '127.0.0.1', 'user_agent' => 'Demo data']);
        ContactMessage::query()->updateOrCreate(['email' => 'roshan@example.com', 'subject' => 'SEO consultation'], ['name' => 'Roshan Lama', 'phone' => '+977 9800000002', 'message' => 'We want to understand why our service pages are not appearing for relevant local searches.', 'status' => 'in_progress', 'ip_address' => '127.0.0.1', 'user_agent' => 'Demo data']);
        QuoteRequest::query()->updateOrCreate(['email' => $customer->email, 'company' => 'Demo Trading'], ['user_id' => $customer->id, 'assigned_to' => $admin->id, 'name' => $customer->name, 'phone' => '+977 9800000003', 'services' => ['Website Design & Development', 'SEO'], 'budget_min' => 10000000, 'budget_max' => 25000000, 'currency' => 'NPR', 'timeline' => '1-3 months', 'message' => 'We need a professional product website with clear enquiries, editable content, and an SEO-ready structure.', 'status' => 'reviewing']);
        QuoteRequest::query()->updateOrCreate(['email' => 'namaste@example.com', 'company' => 'Namaste Experiences'], ['assigned_to' => $admin->id, 'name' => 'Priya Gurung', 'phone' => '+977 9800000004', 'services' => ['Digital Marketing', 'Social Media Marketing'], 'budget_min' => 5000000, 'budget_max' => 10000000, 'currency' => 'NPR', 'timeline' => 'Within 1 month', 'message' => 'We need a three-month launch campaign for a new local travel experience.', 'status' => 'new']);
    }
}

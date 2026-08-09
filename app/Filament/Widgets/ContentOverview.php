<?php

namespace App\Filament\Widgets;

use App\Models\Faq;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Services', Service::query()->count())->icon('heroicon-o-squares-2x2'),
            Stat::make('Portfolio projects', PortfolioProject::query()->count())->icon('heroicon-o-briefcase'),
            Stat::make('Testimonials', Testimonial::query()->count())->icon('heroicon-o-chat-bubble-left-right'),
            Stat::make('Team members', TeamMember::query()->count())->icon('heroicon-o-user-group'),
            Stat::make('FAQs', Faq::query()->count())->icon('heroicon-o-question-mark-circle'),
        ];
    }
}

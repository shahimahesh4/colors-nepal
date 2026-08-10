<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use App\Models\Page;
use App\Models\Service;
use Filament\Widgets\Widget;

class ContentLists extends Widget
{
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return auth()->user()?->hasPermission('view_dashboard_stats') ?? false;
    }
    protected static string $view = 'filament.widgets.content-lists';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'posts' => BlogPost::query()->latest('updated_at')->limit(6)->get(['id', 'title', 'status', 'updated_at']),
            'services' => Service::query()->orderBy('sort_order')->limit(6)->get(['id', 'title', 'status', 'updated_at']),
            'pages' => Page::query()->latest('updated_at')->limit(6)->get(['id', 'title', 'status', 'updated_at']),
        ];
    }
}

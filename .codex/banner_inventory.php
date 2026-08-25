<?php

require dirname(__DIR__).'/vendor/autoload.php';

$app = require dirname(__DIR__).'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo json_encode([
    'pages' => App\Models\Page::query()->get(['id', 'title', 'slug', 'status']),
    'services' => App\Models\Service::query()->get(['id', 'title', 'slug', 'status']),
    'posts' => App\Models\BlogPost::query()->get(['id', 'title', 'slug', 'status']),
    'projects' => App\Models\PortfolioProject::query()->get(['id', 'title', 'slug', 'status']),
    'banners' => App\Models\Banner::query()->get(['id', 'page_key', 'title', 'image', 'is_active']),
], JSON_PRETTY_PRINT);

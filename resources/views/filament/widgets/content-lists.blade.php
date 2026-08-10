<x-filament-widgets::widget>
    <div class="cn-content-lists">
        @foreach ([
            ['title' => 'Recent blog posts', 'icon' => 'heroicon-o-document-text', 'items' => $posts, 'resource' => \App\Filament\Resources\BlogPostResource::class, 'empty' => 'No blog posts yet.'],
            ['title' => 'Services', 'icon' => 'heroicon-o-squares-2x2', 'items' => $services, 'resource' => \App\Filament\Resources\ServiceResource::class, 'empty' => 'No services yet.'],
            ['title' => 'Pages', 'icon' => 'heroicon-o-document-duplicate', 'items' => $pages, 'resource' => \App\Filament\Resources\PageResource::class, 'empty' => 'No pages yet.'],
        ] as $list)
            <section class="cn-content-list-card">
                <header class="cn-content-list-header">
                    <div class="flex items-center gap-3">
                        <x-dynamic-component :component="$list['icon']" class="h-5 w-5 text-primary-600" />
                        <h2 class="font-semibold text-gray-950 dark:text-white">{{ $list['title'] }}</h2>
                    </div>
                    <a href="{{ $list['resource']::getUrl('index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-500">View all</a>
                </header>
                <div class="cn-content-list-body">
                    @forelse ($list['items'] as $item)
                        <a href="{{ $list['resource']::getUrl('edit', ['record' => $item]) }}" class="cn-content-list-item">
                            <div class="min-w-0"><p class="truncate text-sm font-medium text-gray-950 dark:text-white">{{ $item->title }}</p><p class="mt-1 text-xs text-gray-500">Updated {{ $item->updated_at->diffForHumans() }}</p></div>
                            <span @class(['shrink-0 rounded-full px-2 py-1 text-xs font-medium', 'bg-success-50 text-success-700 dark:bg-success-400/10 dark:text-success-400' => $item->status === 'published', 'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-300' => $item->status !== 'published'])>{{ ucfirst($item->status) }}</span>
                        </a>
                    @empty
                        <p class="cn-content-list-empty">{{ $list['empty'] }}</p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-filament-widgets::widget>

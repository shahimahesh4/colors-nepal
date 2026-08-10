<div class="flex items-center gap-2 text-sm">
    <time datetime="{{ now()->toDateString() }}" class="hidden text-gray-500 sm:inline dark:text-gray-400">
        {{ now()->format('D, M j, Y') }}
    </time>
    <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-lg px-3 py-2 font-semibold text-primary-600 transition hover:bg-primary-50 dark:text-primary-400 dark:hover:bg-white/5">
        <x-heroicon-o-arrow-top-right-on-square class="h-5 w-5" />
        <span>Visit website</span>
    </a>
</div>

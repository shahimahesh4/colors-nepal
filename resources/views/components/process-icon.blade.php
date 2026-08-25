@props(['name'])

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('consult')
            <path d="M7 18.5 3.5 21l1.1-4.1A8.5 8.5 0 1 1 7 18.5Z" />
            <path d="M8 10h8M8 14h5" />
            @break
        @case('strategize')
            <circle cx="12" cy="12" r="8" />
            <circle cx="12" cy="12" r="3" />
            <path d="m14.2 9.8 5.3-5.3M16.5 4.5h3v3" />
            @break
        @case('design')
            <path d="m4 20 4.5-1 10-10a2.1 2.1 0 0 0-3-3l-10 10L4 20Z" />
            <path d="m13.8 7.7 3 3M5.5 16l3 3" />
            @break
        @case('develop')
            <path d="m8.5 7-5 5 5 5M15.5 7l5 5-5 5M14 4l-4 16" />
            @break
        @case('launch')
            <path d="M14 5c2.5-2.5 5.5-2 5.5-2s.5 3-2 5.5l-5 5-4-4 5.5-4.5Z" />
            <path d="m8.5 9.5-4 .7L3 13l4.5.5M12.5 13.5l-.7 4L9 19l-.5-4.5" />
            <circle cx="15.5" cy="7" r="1.25" />
            <path d="M6.5 16.5c-1.8.3-3 1.5-3.5 3.5 2-.5 3.2-1.7 3.5-3.5Z" />
            @break
        @case('market')
            <path d="M4 13v-2a2 2 0 0 1 2-2h3l8-4v14l-8-4H6a2 2 0 0 1-2-2Z" />
            <path d="m9 15 1 5H7l-1-5M20 9v6" />
            @break
        @case('optimize')
            <path d="M4 19V5M4 19h16" />
            <path d="m7 15 4-4 3 2 5-6" />
            <path d="M16 7h3v3" />
            @break
    @endswitch
</svg>

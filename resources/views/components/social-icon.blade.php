@props(['platform'])

@switch($platform)
    @case('facebook')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor', 'aria-hidden' => 'true']) }}><path d="M13.5 22v-9h3l.45-3.5H13.5V7.26c0-1.01.28-1.7 1.73-1.7H17.1V2.43c-.32-.04-1.43-.13-2.72-.13-2.69 0-4.53 1.64-4.53 4.66V9.5H6.8V13h3.05v9h3.65Z"/></svg>
        @break
    @case('instagram')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
        @break
    @case('linkedin')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor', 'aria-hidden' => 'true']) }}><path d="M6.5 8.2H3.2V21h3.3V8.2ZM4.85 3A1.94 1.94 0 1 0 4.85 6.88 1.94 1.94 0 0 0 4.85 3ZM21 13.65c0-3.86-2.06-5.66-4.81-5.66-2.22 0-3.21 1.22-3.76 2.08V8.2H9.12V21h3.31v-6.34c0-1.67.32-3.29 2.39-3.29 2.04 0 2.06 1.91 2.06 3.4V21H21v-7.35Z"/></svg>
        @break
    @case('youtube')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor', 'aria-hidden' => 'true']) }}><path d="M23 12s0-3.4-.43-5.04a2.83 2.83 0 0 0-2-2C18.93 4.5 12 4.5 12 4.5s-6.93 0-8.57.46a2.83 2.83 0 0 0-2 2C1 8.6 1 12 1 12s0 3.4.43 5.04a2.83 2.83 0 0 0 2 2c1.64.46 8.57.46 8.57.46s6.93 0 8.57-.46a2.83 2.83 0 0 0 2-2C23 15.4 23 12 23 12Zm-13.2 3.2V8.8l5.75 3.2-5.75 3.2Z"/></svg>
        @break
    @case('x')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor', 'aria-hidden' => 'true']) }}><path d="M18.9 2H22l-6.77 7.74L23.2 22h-6.24l-4.89-6.39L6.48 22H3.36l7.25-8.29L2.96 2H9.36l4.42 5.84L18.9 2Zm-1.1 17.84h1.73L8.42 4.05H6.57L17.8 19.84Z"/></svg>
        @break
    @case('tiktok')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor', 'aria-hidden' => 'true']) }}><path d="M15.5 3c.35 2.2 1.58 3.5 3.5 3.7v3.15a8.1 8.1 0 0 1-3.5-1.05v6.12A6.08 6.08 0 1 1 10.25 9v3.2a2.94 2.94 0 1 0 2.05 2.8V3h3.2Z"/></svg>
        @break
    @case('whatsapp')
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor', 'aria-hidden' => 'true']) }}><path d="M12 2a9.8 9.8 0 0 0-8.47 14.74L2 22l5.39-1.42A9.99 9.99 0 1 0 12 2Zm0 17.8a7.8 7.8 0 0 1-3.98-1.09l-.29-.17-3.2.84.85-3.11-.19-.31A7.79 7.79 0 1 1 12 19.8Zm4.28-5.83c-.23-.12-1.39-.68-1.6-.76-.22-.08-.38-.12-.54.12-.16.23-.62.76-.76.92-.14.16-.28.18-.51.06-2.02-1.01-3.34-1.8-4.67-4.09-.35-.6.35-.56 1.01-1.85.12-.23.06-.43-.03-.55-.08-.12-.54-1.3-.74-1.78-.2-.47-.4-.41-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.23-.84.82-.84 2 0 1.18.86 2.32.98 2.48.12.16 1.69 2.58 4.1 3.62 1.52.66 2.12.71 2.88.6.46-.07 1.39-.57 1.58-1.12.2-.55.2-1.02.14-1.12-.06-.1-.22-.16-.46-.28Z"/></svg>
        @break
    @default
        <svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>@endswitch

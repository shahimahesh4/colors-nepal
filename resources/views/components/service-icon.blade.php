@props(['title' => ''])
@php($serviceKey = \Illuminate\Support\Str::slug($title))

<div {{ $attributes->class('service-card__icon') }} aria-hidden="true">
    @switch($serviceKey)
        @case('website-design-development')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="61" cy="47" r="34" fill="#E0F7F2"/><rect x="21" y="20" width="78" height="57" rx="7" fill="white" stroke="#0066CC" stroke-width="3"/><path d="M21 34h78" stroke="#0066CC" stroke-width="3"/><circle cx="29" cy="27" r="2.5" fill="#E63980"/><circle cx="37" cy="27" r="2.5" fill="#00B4A6"/><circle cx="45" cy="27" r="2.5" fill="#FFC107"/><rect x="30" y="43" width="27" height="4" rx="2" fill="#00B4A6"/><rect x="30" y="51" width="20" height="3" rx="1.5" fill="#B8DDFF"/><rect x="64" y="42" width="25" height="23" rx="4" fill="#0066CC"/><path d="m69 59 6-7 5 5 4-4" stroke="white" stroke-width="2.5"/></svg>
            @break
        @case('digital-marketing')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="60" cy="48" r="35" fill="#FFF4E5"/><path d="M28 52V39l45-16v45L28 52Z" fill="white" stroke="#E63980" stroke-width="3"/><path d="M73 31c10 4 15 9 15 15s-5 11-15 15" stroke="#FF8A00" stroke-width="4" stroke-linecap="round"/><path d="m31 53 7 23h14l-9-19" fill="#0066CC"/><path d="M88 25l5-7M92 35l9-3M91 58l8 4" stroke="#00B4A6" stroke-width="3" stroke-linecap="round"/><circle cx="29" cy="45" r="4" fill="#FFC107"/></svg>
            @break
        @case('search-engine-optimization')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="58" cy="45" r="34" fill="#EFF7FF"/><rect x="25" y="18" width="69" height="52" rx="7" fill="white" stroke="#0066CC" stroke-width="3"/><path d="m35 57 12-11 10 6 15-18 12 8" stroke="#00B4A6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><circle cx="77" cy="58" r="14" fill="#E0F7F2" stroke="#E63980" stroke-width="3"/><path d="m87 68 11 11" stroke="#E63980" stroke-width="5" stroke-linecap="round"/><path d="m72 58 4 4 7-9" stroke="#0066CC" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            @break
        @case('social-media-marketing')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="60" cy="47" r="35" fill="#FDEAF2"/><rect x="42" y="12" width="37" height="72" rx="9" fill="#0066CC" stroke="#0D1B2A" stroke-width="3"/><rect x="47" y="21" width="27" height="51" rx="4" fill="white"/><path d="M48 42c0-6 9-8 12-2 3-6 12-4 12 2 0 8-12 14-12 14S48 50 48 42Z" fill="#E63980"/><circle cx="61" cy="78" r="2" fill="white"/><circle cx="86" cy="29" r="9" fill="#00B4A6"/><path d="M82 29h8M86 25v8" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
            @break
        @case('web-hosting')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="60" cy="49" r="35" fill="#E0F7F2"/><path d="M40 37c2-11 12-19 24-19 13 0 23 8 25 20 8 1 14 7 14 15 0 9-7 16-17 16H40c-10 0-18-7-18-16 0-8 7-15 18-16Z" fill="white" stroke="#0066CC" stroke-width="3"/><rect x="38" y="51" width="47" height="25" rx="5" fill="#0D1B2A"/><path d="M43 59h37M43 68h37" stroke="#3A9BFF" stroke-width="2"/><circle cx="76" cy="59" r="2" fill="#00B4A6"/><circle cx="70" cy="68" r="2" fill="#FFC107"/><circle cx="76" cy="68" r="2" fill="#E63980"/></svg>
            @break
        @case('domain-registration')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="59" cy="47" r="35" fill="#EFF7FF"/><circle cx="54" cy="47" r="27" fill="white" stroke="#0066CC" stroke-width="3"/><path d="M27 47h54M54 20c8 8 12 17 12 27S62 66 54 74M54 20c-8 8-12 17-12 27s4 19 12 27" stroke="#00B4A6" stroke-width="2.5"/><path d="M30 34h48M30 60h48" stroke="#B8DDFF" stroke-width="2"/><path d="m72 55 17-17 12 12-17 17-15 3 3-15Z" fill="#FF8A00" stroke="#E63980" stroke-width="2.5"/><circle cx="90" cy="49" r="2.5" fill="white"/></svg>
            @break
        @case('website-maintenance')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="60" cy="48" r="35" fill="#FFF8DB"/><rect x="24" y="18" width="72" height="54" rx="7" fill="white" stroke="#0066CC" stroke-width="3"/><path d="M24 31h72" stroke="#0066CC" stroke-width="3"/><path d="M40 51a15 15 0 0 0 23 13L82 83l9-9-19-19a15 15 0 0 0-20-19l9 9-9 9-12-3Z" fill="#00B4A6" stroke="#0D1B2A" stroke-width="2.5"/><circle cx="32" cy="25" r="2" fill="#E63980"/><circle cx="39" cy="25" r="2" fill="#FFC107"/></svg>
            @break
        @case('branding-online-promotion')
            <svg viewBox="0 0 120 96" fill="none"><circle cx="60" cy="48" r="35" fill="#FDEAF2"/><path d="M61 16c-22 0-39 13-39 31 0 15 13 27 29 27h7c5 0 8-5 5-9l-2-3c-2-4 1-8 6-8h11c12 0 20-8 20-18 0-12-16-20-37-20Z" fill="white" stroke="#0066CC" stroke-width="3"/><circle cx="40" cy="43" r="6" fill="#E63980"/><circle cx="55" cy="32" r="6" fill="#FF8A00"/><circle cx="72" cy="34" r="6" fill="#FFC107"/><circle cx="83" cy="48" r="6" fill="#00B4A6"/><path d="m67 76 19-25 8 6-19 25-11 3 3-9Z" fill="#0066CC" stroke="#0D1B2A" stroke-width="2"/></svg>
            @break
        @default
            <svg viewBox="0 0 120 96" fill="none"><circle cx="60" cy="48" r="35" fill="#EFF7FF"/><path d="M34 70V36l27-16 27 16v34L61 86 34 70Z" fill="white" stroke="#0066CC" stroke-width="3"/><path d="m61 20 27 16-27 16-27-16 27-16Z" fill="#B8DDFF"/><path d="M61 52v34M34 36l27 16 27-16" stroke="#0066CC" stroke-width="3"/></svg>
    @endswitch
</div>

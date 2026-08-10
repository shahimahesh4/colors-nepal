@props(['compact' => false, 'mobile' => false])

@php
    $brandName = $siteSettings->get('site_name') ?: config('app.name');
    $logo = $mobile ? ($siteSettings->get('mobile_logo') ?: $siteSettings->get('logo')) : $siteSettings->get('logo');
@endphp

<span {{ $attributes->class('inline-flex items-center gap-3 font-bold tracking-tight text-ink-950') }}>
    @if ($logo)
        <img src="{{ asset('storage/'.$logo) }}" alt="{{ $brandName }}" class="h-11 w-auto max-w-52 object-contain sm:h-12 sm:max-w-56">
    @else
        <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-ink-950 text-sm text-white shadow-sm" aria-hidden="true">
            {{ str($brandName)->substr(0, 2)->upper() }}
        </span>
        @unless ($compact)
            <span class="text-lg">{{ $brandName }}</span>
        @endunless
    @endif
</span>

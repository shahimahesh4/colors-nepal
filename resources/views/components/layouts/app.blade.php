@props([
'title'=>null,
'description'=>'Colors Nepal provides practical website, marketing, SEO, hosting, and digital growth services.',
'canonical'=>null,
'image'=>null,
'type'=>'website',
])
@php
$pageTitle=$title ? $title.' | '.config('app.name') : config('app.name');
$canonicalUrl=$canonical ?: request()->url();
$socialImage=$image ? (str_starts_with($image,'http') ? $image : asset($image)) : null;
$organizationSchema=['@context'=>'https://schema.org','@type'=>'Organization','name'=>config('app.name'),'url'=>route('home')];
@endphp
<!DOCTYPE html><html lang="{{ str_replace('_','-',app()->getLocale()) }}"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $pageTitle }}</title><meta name="description" content="{{ $description }}"><link rel="canonical" href="{{ $canonicalUrl }}">
<meta property="og:type" content="{{ $type }}"><meta property="og:title" content="{{ $pageTitle }}"><meta property="og:description" content="{{ $description }}"><meta property="og:url" content="{{ $canonicalUrl }}"><meta property="og:site_name" content="{{ config('app.name') }}">
<meta name="twitter:card" content="{{ $socialImage ? 'summary_large_image' : 'summary' }}"><meta name="twitter:title" content="{{ $pageTitle }}"><meta name="twitter:description" content="{{ $description }}">
@if($socialImage)<meta property="og:image" content="{{ $socialImage }}"><meta name="twitter:image" content="{{ $socialImage }}">@endif
<script type="application/ld+json">{!! json_encode($organizationSchema,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP) !!}</script>
{{ $head ?? '' }}
@vite(['resources/css/app.css','resources/js/app.js'])
</head><body class="min-h-screen bg-white">
<a href="#main-content" class="fixed left-4 top-4 z-[100] -translate-y-24 rounded-control bg-ink-950 px-4 py-2 font-semibold text-white transition focus:translate-y-0">Skip to content</a>
<div class="flex min-h-screen flex-col"><x-site-header /><main id="main-content" class="flex-1">{{ $slot }}</main><x-site-footer /></div>
</body></html>

@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'canonical' => null,
    'image' => null,
    'type' => 'website',
])

@php
    $siteName = $siteSettings->get('site_name') ?: config('app.name');
    $defaultTitle = $siteSettings->get('default_meta_title') ?: $siteName;
    $pageTitle = $title ? $title.' | '.$siteName : $defaultTitle;
    $pageDescription = $description ?: ($siteSettings->get('default_meta_description') ?: 'Colors Nepal provides practical website, marketing, SEO, hosting, and digital growth services.');
    $pageKeywords = $keywords ?: $siteSettings->get('default_meta_keywords');
    $canonicalUrl = $canonical ?: request()->url();
    $defaultSocialImage = $siteSettings->get('default_og_image');
    $socialImage = $image
        ? (str_starts_with($image, 'http') ? $image : asset($image))
        : ($defaultSocialImage ? asset('storage/'.$defaultSocialImage) : null);
    $favicon = $siteSettings->get('favicon');
    $logo = $siteSettings->get('logo');
    $analyticsId = $siteSettings->get('google_analytics_enabled') === '1' ? $siteSettings->get('google_analytics_id') : null;
    $analyticsId = is_string($analyticsId) && preg_match('/^G-[A-Z0-9]+$/i', $analyticsId) ? strtoupper($analyticsId) : null;
    $tagManagerId = $siteSettings->get('google_tag_manager_enabled') === '1' ? $siteSettings->get('google_tag_manager_id') : null;
    $tagManagerId = is_string($tagManagerId) && preg_match('/^GTM-[A-Z0-9]+$/i', $tagManagerId) ? strtoupper($tagManagerId) : null;
    $organizationSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $siteName,
        'url' => route('home'),
    ];

    if ($logo) {
        $organizationSchema['logo'] = asset('storage/'.$logo);
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if ($tagManagerId)
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $tagManagerId }}');</script>
    @endif
    @if ($analyticsId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsId }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ $analyticsId }}');</script>
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large">
    @if ($pageKeywords)<meta name="keywords" content="{{ $pageKeywords }}">@endif
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @if ($favicon)
        <link rel="icon" href="{{ asset('storage/'.$favicon) }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/'.$favicon) }}">
    @endif

    <meta property="og:type" content="{{ $type }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
    <meta name="twitter:card" content="{{ $socialImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    @if ($socialImage)
        <meta property="og:image" content="{{ $socialImage }}">
        <meta property="og:image:alt" content="{{ $pageTitle }}">
        <meta name="twitter:image" content="{{ $socialImage }}">
        <meta name="twitter:image:alt" content="{{ $pageTitle }}">
    @endif

    <script type="application/ld+json">{!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    {{ $head ?? '' }}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-white">
    @if ($tagManagerId)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $tagManagerId }}" height="0" width="0" class="hidden invisible" title="Google Tag Manager"></iframe></noscript>
    @endif
    <a href="#main-content" class="fixed left-4 top-4 z-[100] -translate-y-24 rounded-control bg-ink-950 px-4 py-2 font-semibold text-white transition focus:translate-y-0">Skip to content</a>
    <div class="flex min-h-screen flex-col">
        <x-site-header />
        <main id="main-content" class="flex-1">{{ $slot }}</main>
        <x-site-footer />
    </div>
    @livewireScripts
</body>
</html>

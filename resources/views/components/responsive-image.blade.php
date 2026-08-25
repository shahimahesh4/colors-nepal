@props([
    'path',
    'alt' => '',
    'width' => null,
    'height' => null,
    'sizes' => '100vw',
    'loading' => 'lazy',
    'fetchpriority' => null,
])

@php
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    $directory = pathinfo($path, PATHINFO_DIRNAME);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $prefix = $directory === '.' ? '' : $directory.'/';

    if ((! $width || ! $height) && $disk->exists($path)) {
        $dimensions = @getimagesize($disk->path($path));
        $width = $width ?: ($dimensions[0] ?? null);
        $height = $height ?: ($dimensions[1] ?? null);
    }

    $webpSources = [];

    foreach ([480, 768, 1200] as $candidateWidth) {
        $candidate = $prefix.$filename.'-'.$candidateWidth.'.webp';

        if ((! $width || $candidateWidth < $width) && $disk->exists($candidate)) {
            $webpSources[] = asset('storage/'.$candidate).' '.$candidateWidth.'w';
        }
    }

    $fullWebp = $prefix.$filename.'.webp';

    if ($disk->exists($fullWebp)) {
        $webpSources[] = asset('storage/'.$fullWebp).($width ? ' '.$width.'w' : '');
    }
@endphp

<picture class="block">
    @if ($webpSources)
        <source type="image/webp" srcset="{{ implode(', ', $webpSources) }}" sizes="{{ $sizes }}">
    @endif
    <img
        src="{{ asset('storage/'.$path) }}"
        alt="{{ $alt }}"
        @if ($width) width="{{ $width }}" @endif
        @if ($height) height="{{ $height }}" @endif
        loading="{{ $loading }}"
        decoding="async"
        @if ($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
        {{ $attributes }}
    >
</picture>

@php
    $enabled = $siteSettings->get('recaptcha_enabled') === '1';
    $siteKey = $siteSettings->get('recaptcha_site_key');
@endphp
@if ($enabled && $siteKey)
    <div>
        <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
        @error('g-recaptcha-response')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
    </div>
    @once <script src="https://www.google.com/recaptcha/api.js" async defer></script> @endonce
@endif

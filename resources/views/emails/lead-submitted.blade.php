<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $type }}</title></head>
<body style="margin:0;background:#f4f7fa;color:#0d1b2a;font-family:Arial,sans-serif;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f7fa;padding:32px 16px;"><tr><td align="center">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(13,27,42,.08);">
<tr><td style="height:6px;background:#0066cc;"></td></tr>
<tr><td style="padding:28px 32px 20px;text-align:center;">@if ($logoUrl)<img src="{{ $logoUrl }}" alt="{{ $siteName }}" style="display:inline-block;max-height:64px;max-width:240px;width:auto;">@else<div style="font-size:24px;font-weight:700;color:#0d1b2a;">{{ $siteName }}</div>@endif</td></tr>
<tr><td style="padding:8px 32px 32px;"><p style="margin:0 0 8px;color:#ec3980;font-size:13px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">Website enquiry</p><h1 style="margin:0 0 20px;font-size:28px;line-height:1.25;color:#0d1b2a;">{{ $type }}</h1>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:24px;background:#f7fafc;border:1px solid #e5edf3;border-radius:12px;"><tr><td style="padding:18px 20px;line-height:1.7;"><strong>Name:</strong> {{ $name }}<br><strong>Email:</strong> <a href="mailto:{{ $email }}" style="color:#0066cc;">{{ $email }}</a><br><strong>Summary:</strong> {{ $summary ?: 'Not provided' }}</td></tr></table>
<a href="{{ $adminUrl }}" style="display:inline-block;padding:13px 22px;border-radius:9px;background:#0066cc;color:#fff;text-decoration:none;font-weight:700;">Review in STNA Panel</a></td></tr>
<tr><td style="padding:24px 32px;background:#0d1b2a;color:#cbd5e1;font-size:13px;line-height:1.7;text-align:center;"><strong style="color:#fff;">{{ $siteName }}</strong><br>@if ($contactEmail)<a href="mailto:{{ $contactEmail }}" style="color:#55d6c9;text-decoration:none;">{{ $contactEmail }}</a>@endif @if ($contactPhone)<span>&nbsp; · &nbsp;{{ $contactPhone }}</span>@endif @if ($contactAddress)<br>{{ $contactAddress }}@endif</td></tr>
</table></td></tr></table></body></html>
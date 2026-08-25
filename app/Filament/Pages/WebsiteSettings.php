<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Models\SocialLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class WebsiteSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Website Settings';

    protected static ?string $title = 'Website Settings';

    protected static ?int $navigationSort = 90;

    protected static string $view = 'filament.pages.website-settings';

    public ?array $data = [];

    private const DEFINITIONS = [
        'site_name' => ['text', 'general'],
        'default_currency' => ['text', 'general'],
        'contact_email' => ['email', 'contact'],
        'contact_phone' => ['text', 'contact'],
        'contact_address' => ['text', 'contact'],
        'maintenance_enabled' => ['boolean', 'maintenance'],
        'maintenance_title' => ['text', 'maintenance'],
        'maintenance_message' => ['textarea', 'maintenance'],
        'maintenance_show_contact' => ['boolean', 'maintenance'],
        'about_intro' => ['textarea', 'about'],
        'mission' => ['textarea', 'about'],
        'vision' => ['textarea', 'about'],
        'logo' => ['image', 'branding'],
        'mobile_logo' => ['image', 'branding'],
        'favicon' => ['image', 'branding'],
        'default_meta_title' => ['text', 'seo'],
        'default_meta_description' => ['textarea', 'seo'],
        'default_meta_keywords' => ['text', 'seo'],
        'default_og_image' => ['image', 'seo'],
        'email_otp_enabled' => ['boolean', 'authentication'],
        'phone_otp_enabled' => ['boolean', 'authentication'],
        'sparrow_sms_endpoint' => ['url', 'authentication'],
        'sparrow_sms_identity' => ['text', 'authentication'],
        'sparrow_sms_token' => ['password', 'authentication'],
        'sparrow_sms_template' => ['textarea', 'authentication'],
        'recaptcha_enabled' => ['boolean', 'security'],
        'recaptcha_site_key' => ['text', 'security'],
        'recaptcha_secret_key' => ['password', 'security'],
        'google_analytics_enabled' => ['boolean', 'analytics'],
        'google_analytics_id' => ['text', 'analytics'],
        'google_tag_manager_enabled' => ['boolean', 'analytics'],
        'google_tag_manager_id' => ['text', 'analytics'],
    ];

    public static function canAccess(): bool
    {
        return auth()->user()?->hasPermission('manage_settings') ?? false;
    }

    public function mount(): void
    {
        abort_unless(static::canAccess(), 403);

        $values = SiteSetting::query()->pluck('value', 'key')->all();

        foreach (self::DEFINITIONS as $key => [$type]) {
            $this->data[$key] = match ($type) {
                'boolean' => ($values[$key] ?? '0') === '1',
                'password' => null,
                default => $key === 'default_meta_keywords'
                    ? array_values(array_filter(array_map('trim', explode(',', $values[$key] ?? ''))))
                    : ($values[$key] ?? null),
            };
        }

        $this->data['social_links'] = SocialLink::query()
            ->orderBy('sort_order')
            ->get(['id', 'name', 'icon', 'url', 'is_active', 'sort_order'])
            ->toArray();

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Construction Mode')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->badge(fn (Forms\Get $get): ?string => $get('maintenance_enabled') ? 'Active' : null)
                            ->schema([
                                Forms\Components\Section::make('Public website availability')
                                    ->description('The admin panel remains available while construction mode is active.')
                                    ->schema([
                                        Forms\Components\Toggle::make('maintenance_enabled')
                                            ->label('Enable under-construction page')
                                            ->helperText('Visitors will see a temporary maintenance page with HTTP status 503.')
                                            ->live()
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('maintenance_title')
                                            ->label('Page heading')
                                            ->required(fn (Forms\Get $get): bool => (bool) $get('maintenance_enabled'))
                                            ->maxLength(120)
                                            ->visible(fn (Forms\Get $get): bool => (bool) $get('maintenance_enabled'))
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('maintenance_message')
                                            ->label('Visitor message')
                                            ->required(fn (Forms\Get $get): bool => (bool) $get('maintenance_enabled'))
                                            ->rows(4)
                                            ->maxLength(500)
                                            ->visible(fn (Forms\Get $get): bool => (bool) $get('maintenance_enabled'))
                                            ->columnSpanFull(),
                                        Forms\Components\Toggle::make('maintenance_show_contact')
                                            ->label('Show contact email')
                                            ->visible(fn (Forms\Get $get): bool => (bool) $get('maintenance_enabled')),
                                    ])->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('General')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\Section::make('Business information')->schema([
                                    Forms\Components\TextInput::make('site_name')->label('Site name')->required()->maxLength(255),
                                    Forms\Components\TextInput::make('default_currency')->label('Default currency')->required()->maxLength(10),
                                    Forms\Components\TextInput::make('contact_email')->label('Contact email')->email()->maxLength(255),
                                    Forms\Components\TextInput::make('contact_phone')->label('Contact phone')->tel()->maxLength(30),
                                    Forms\Components\TextInput::make('contact_address')->label('Contact address')->maxLength(255)->columnSpanFull(),
                                ])->columns(2),
                                Forms\Components\Section::make('About content')->schema([
                                    Forms\Components\Textarea::make('about_intro')->label('Introduction')->rows(4),
                                    Forms\Components\Textarea::make('mission')->rows(4),
                                    Forms\Components\Textarea::make('vision')->rows(4),
                                ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Branding')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Section::make('Logos and browser icon')
                                    ->description('PNG, JPG or WebP. Maximum 2 MB per image.')
                                    ->schema([
                                        $this->imageUpload('logo', 'Main logo'),
                                        $this->imageUpload('mobile_logo', 'Mobile logo'),
                                        $this->imageUpload('favicon', 'Favicon'),
                                    ])->columns(3),
                            ]),
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\Section::make('Default search and social metadata')->schema([
                                    Forms\Components\TextInput::make('default_meta_title')->label('Meta title')->maxLength(70)->columnSpanFull(),
                                    Forms\Components\Textarea::make('default_meta_description')->label('Meta description')->rows(4)->maxLength(170)->columnSpanFull(),
                                    Forms\Components\TagsInput::make('default_meta_keywords')->label('Meta keywords')->separator(',')->helperText('Press Enter after each keyword.')->columnSpanFull(),
                                    $this->imageUpload('default_og_image', 'Default social sharing image')->columnSpanFull(),
                                ])->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\Section::make('Footer social links')
                                    ->description('Add, reorder, enable, or disable social profiles shown on the website.')
                                    ->schema([
                                        Forms\Components\Repeater::make('social_links')
                                            ->hiddenLabel()
                                            ->schema([
                                                Forms\Components\Hidden::make('id'),
                                                Forms\Components\TextInput::make('name')->required()->maxLength(50),
                                                Forms\Components\Select::make('icon')->required()->options([
                                                    'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn',
                                                    'youtube' => 'YouTube', 'x' => 'X / Twitter', 'tiktok' => 'TikTok',
                                                    'whatsapp' => 'WhatsApp', 'link' => 'Other / Link',
                                                ])->searchable(),
                                                Forms\Components\TextInput::make('url')->url()->required()->maxLength(255)->columnSpan(2),
                                                Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                                                Forms\Components\TextInput::make('sort_order')->label('Order')->numeric()->default(0)->minValue(0),
                                            ])->columns(2)->reorderable()->collapsible()->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Social link'),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Authentication & SMS')
                            ->icon('heroicon-o-device-phone-mobile')
                            ->schema([
                                Forms\Components\Section::make('Login verification')->schema([
                                    Forms\Components\Toggle::make('email_otp_enabled')->label('Enable email OTP')->live(),
                                    Forms\Components\Toggle::make('phone_otp_enabled')->label('Enable phone OTP')->live(),
                                ])->columns(2),
                                Forms\Components\Section::make('Sparrow SMS')
                                    ->description('Required only when phone OTP is enabled.')
                                    ->visible(fn (Forms\Get $get): bool => (bool) $get('phone_otp_enabled'))
                                    ->schema([
                                        Forms\Components\TextInput::make('sparrow_sms_endpoint')->label('API endpoint')->url()->maxLength(255),
                                        Forms\Components\TextInput::make('sparrow_sms_identity')->label('Identity')->maxLength(100),
                                        Forms\Components\TextInput::make('sparrow_sms_token')->label('API token')->password()->revealable()->helperText('Leave blank to keep the existing token.')->columnSpanFull(),
                                        Forms\Components\Textarea::make('sparrow_sms_template')->label('Message template')->rows(4)->helperText('Available variables: {{ site_name }} and {{ otp }}.')->columnSpanFull(),
                                    ])->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Security')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Forms\Components\Section::make('Google reCAPTCHA')->schema([
                                    Forms\Components\Toggle::make('recaptcha_enabled')->label('Enable reCAPTCHA')->live(),
                                    Forms\Components\TextInput::make('recaptcha_site_key')->label('Site key')->visible(fn (Forms\Get $get): bool => (bool) $get('recaptcha_enabled')),
                                    Forms\Components\TextInput::make('recaptcha_secret_key')->label('Secret key')->password()->revealable()->helperText('Leave blank to keep the existing secret.')->visible(fn (Forms\Get $get): bool => (bool) $get('recaptcha_enabled')),
                                ])->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Analytics')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Forms\Components\Section::make('Google Analytics')->schema([
                                    Forms\Components\Toggle::make('google_analytics_enabled')->label('Enable Google Analytics')->live(),
                                    Forms\Components\TextInput::make('google_analytics_id')->label('Measurement ID')->placeholder('G-XXXXXXXXXX')->regex('/^G-[A-Z0-9]+$/i')->visible(fn (Forms\Get $get): bool => (bool) $get('google_analytics_enabled')),
                                ])->columns(2),
                                Forms\Components\Section::make('Google Tag Manager')->schema([
                                    Forms\Components\Toggle::make('google_tag_manager_enabled')->label('Enable Google Tag Manager')->live(),
                                    Forms\Components\TextInput::make('google_tag_manager_id')->label('Container ID')->placeholder('GTM-XXXXXXX')->regex('/^GTM-[A-Z0-9]+$/i')->visible(fn (Forms\Get $get): bool => (bool) $get('google_tag_manager_enabled')),
                                ])->columns(2),
                            ]),
                    ])->persistTabInQueryString()->columnSpanFull(),
            ])
            ->statePath('data');
    }

    private function imageUpload(string $name, string $label): Forms\Components\FileUpload
    {
        return Forms\Components\FileUpload::make($name)
            ->label($label)
            ->image()
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->maxSize(2048)
            ->disk('public')
            ->visibility('public')
            ->directory('settings')
            ->imageResizeMode($name === 'default_og_image' ? 'cover' : 'contain')
            ->imageResizeTargetWidth($name === 'default_og_image' ? '1200' : '1600')
            ->imageResizeTargetHeight($name === 'default_og_image' ? '630' : '1200')
            ->imageResizeUpscale(false)
            ->imageEditor();
    }

    public function save(): void
    {
        abort_unless(static::canAccess(), 403);
        $state = $this->form->getState();

        DB::transaction(function () use ($state): void {
            foreach (self::DEFINITIONS as $key => [$type, $group]) {
                $value = $state[$key] ?? null;

                if ($type === 'password' && blank($value)) {
                    continue;
                }

                if ($type === 'boolean') {
                    $value = $value ? '1' : '0';
                } elseif ($key === 'default_meta_keywords' && is_array($value)) {
                    $value = implode(', ', $value);
                }

                SiteSetting::query()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'type' => $type, 'group' => $group],
                );
            }

            $keptIds = [];
            foreach ($state['social_links'] ?? [] as $index => $link) {
                $attributes = [
                    'name' => $link['name'],
                    'icon' => $link['icon'],
                    'url' => $link['url'],
                    'is_active' => (bool) ($link['is_active'] ?? false),
                    'sort_order' => (int) ($link['sort_order'] ?? $index),
                ];

                $record = filled($link['id'] ?? null)
                    ? SocialLink::query()->findOrFail($link['id'])
                    : new SocialLink();
                $record->fill($attributes)->save();
                $keptIds[] = $record->getKey();
            }

            SocialLink::query()->when($keptIds, fn ($query) => $query->whereNotIn('id', $keptIds))->delete();
        });

        Cache::forget('footer-social-links');

        Notification::make()->title('Website settings saved')->success()->send();
        $this->mount();
    }
}

<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use App\Models\Banner;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class ManageHomeBanner extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = BannerResource::class;

    protected static string $view = 'filament.resources.banner-resource.pages.manage-home-banner';

    protected static ?string $title = 'Home Page Banner';

    public ?array $data = [];

    public function mount(): void
    {
        $banner = Banner::query()->firstOrCreate(
            ['page_key' => 'home'],
            ['title' => 'Digital work built to move your business forward.', 'image' => Banner::DEFAULT_IMAGE, 'is_active' => true],
        );

        $this->form->fill($banner->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Home Page Banner')
                ->description('The homepage uses a larger hero layout than internal pages.')
                ->schema([
                    Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                    Forms\Components\TextInput::make('title')->label('Banner title')->required()->maxLength(255)->columnSpanFull(),
                    Forms\Components\Textarea::make('description')->label('Banner text / description')->rows(4)->maxLength(1000)->columnSpanFull(),
                    Forms\Components\FileUpload::make('image')->label('Banner image')->image()->imagePreviewHeight('280')->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120)->disk('public')->visibility('public')->directory('banners/home')->imageResizeMode('contain')->imageResizeTargetWidth('1600')->imageResizeTargetHeight('1000')->imageResizeUpscale(false)->imageEditor()->helperText('Optional. The built-in digital services illustration is used when empty.')->columnSpanFull(),
                    Forms\Components\TextInput::make('button_text')->label('Button text')->maxLength(80),
                    Forms\Components\TextInput::make('button_url')->label('Button link')->placeholder('/request-quote')->maxLength(2048),
                ])->columns(2),
        ])->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [Action::make('save')->label('Save Home Banner')->icon('heroicon-o-check-circle')->action('save')];
    }

    public function save(): void
    {
        Banner::query()->updateOrCreate(['page_key' => 'home'], $this->form->getState());
        Notification::make()->title('Home banner saved')->success()->send();
    }
}

<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('home')->label('Home Page Banner')->icon('heroicon-o-home')->url(BannerResource::getUrl('home')),
            Actions\CreateAction::make()->label('New Page Banner'),
        ];
    }
}

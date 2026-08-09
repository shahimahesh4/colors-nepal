<?php

namespace App\Filament\Resources\DomainTldResource\Pages;

use App\Filament\Resources\DomainTldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDomainTlds extends ListRecords
{
    protected static string $resource = DomainTldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

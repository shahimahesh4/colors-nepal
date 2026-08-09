<?php

namespace App\Filament\Resources\DomainTldResource\Pages;

use App\Filament\Resources\DomainTldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDomainTld extends EditRecord
{
    protected static string $resource = DomainTldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

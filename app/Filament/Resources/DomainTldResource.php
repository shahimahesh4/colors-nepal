<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\DomainTldResource\Pages;
use App\Models\DomainTld;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DomainTldResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = DomainTld::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 81;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('extension')->required()->maxLength(255)->unique(ignoreRecord: true)->placeholder('.com'),
            Forms\Components\TextInput::make('registration_price')->required()->numeric()->minValue(0)->helperText('Minor units, e.g. paisa.'),
            Forms\Components\TextInput::make('renewal_price')->numeric()->minValue(0)->helperText('Minor units, e.g. paisa.'),
            Forms\Components\TextInput::make('currency')->required()->length(3)->default('NPR'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('sort_order')->numeric()->minValue(0)->required()->default(0),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            Tables\Columns\TextColumn::make('extension')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('registration_price')->money(fn (DomainTld $record): string => $record->currency, divideBy: 100)->sortable(),
            Tables\Columns\TextColumn::make('renewal_price')->money(fn (DomainTld $record): string => $record->currency, divideBy: 100)->sortable(),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
        ])->filters([Tables\Filters\TernaryFilter::make('is_active')->label('Active')])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListDomainTlds::route('/'), 'create' => Pages\CreateDomainTld::route('/create'), 'edit' => Pages\EditDomainTld::route('/{record}/edit')];
    }
}

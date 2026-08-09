<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Setting')->schema([
                Forms\Components\TextInput::make('key')->required()->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\Select::make('type')->options(['text' => 'Text', 'textarea' => 'Long text', 'url' => 'URL', 'email' => 'Email'])->required()->default('text'),
                Forms\Components\TextInput::make('group')->required()->maxLength(100)->default('general'),
                Forms\Components\Textarea::make('value')->rows(5)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('key')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('value')->limit(50)->searchable(),
            Tables\Columns\TextColumn::make('type')->badge(),
            Tables\Columns\TextColumn::make('group')->badge()->sortable(),
            Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('group')->options(fn (): array => SiteSetting::query()->distinct()->pluck('group', 'group')->all()),
        ])->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListSiteSettings::route('/'), 'create' => Pages\CreateSiteSetting::route('/create'), 'edit' => Pages\EditSiteSetting::route('/{record}/edit')];
    }
}

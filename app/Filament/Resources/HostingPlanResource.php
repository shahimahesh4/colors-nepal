<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\HostingPlanResource\Pages;
use App\Models\HostingPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HostingPlanResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = HostingPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationGroup = 'Products';

    protected static ?int $navigationSort = 80;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
            Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
            Forms\Components\TagsInput::make('features')->columnSpanFull(),
            Forms\Components\TextInput::make('monthly_price')->numeric()->minValue(0)->helperText('Minor units, e.g. paisa.'),
            Forms\Components\TextInput::make('yearly_price')->numeric()->minValue(0)->helperText('Minor units, e.g. paisa.'),
            Forms\Components\TextInput::make('currency')->required()->length(3)->default('NPR'),
            Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->required()->default('draft'),
            Forms\Components\Toggle::make('is_featured')->default(false),
            Forms\Components\TextInput::make('sort_order')->numeric()->minValue(0)->required()->default(0),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('monthly_price')->money(fn (HostingPlan $record): string => $record->currency, divideBy: 100)->sortable(),
            Tables\Columns\TextColumn::make('yearly_price')->money(fn (HostingPlan $record): string => $record->currency, divideBy: 100)->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
            Tables\Columns\IconColumn::make('is_featured')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(['draft' => 'Draft', 'published' => 'Published']),
            Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
        ])->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListHostingPlans::route('/'), 'create' => Pages\CreateHostingPlan::route('/create'), 'edit' => Pages\EditHostingPlan::route('/{record}/edit')];
    }
}

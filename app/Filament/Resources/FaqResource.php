<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 50;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('group')->required()->maxLength(100)->default('general'),
            Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->required()->default('draft'),
            Forms\Components\TextInput::make('question')->required()->maxLength(255)->columnSpanFull(),
            Forms\Components\Textarea::make('answer')->required()->rows(6)->columnSpanFull(),
            Forms\Components\TextInput::make('sort_order')->numeric()->minValue(0)->required()->default(0),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            Tables\Columns\TextColumn::make('group')->badge()->searchable()->sortable(),
            Tables\Columns\TextColumn::make('question')->searchable()->limit(70),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
            Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(['draft' => 'Draft', 'published' => 'Published']),
            Tables\Filters\SelectFilter::make('group')->options(fn (): array => Faq::query()->distinct()->pluck('group', 'group')->all()),
        ])->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListFaqs::route('/'), 'create' => Pages\CreateFaq::route('/create'), 'edit' => Pages\EditFaq::route('/{record}/edit')];
    }
}

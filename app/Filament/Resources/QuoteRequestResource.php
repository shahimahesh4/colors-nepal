<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteRequestResource\Pages;
use App\Models\QuoteRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?string $navigationGroup = 'Leads';

    protected static ?int $navigationSort = 71;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Request')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('company')->disabled(),
                Forms\Components\TagsInput::make('services')->disabled(),
                Forms\Components\TextInput::make('budget_min')->numeric()->helperText('Stored in minor currency units.')->disabled(),
                Forms\Components\TextInput::make('budget_max')->numeric()->disabled(),
                Forms\Components\TextInput::make('currency')->disabled(),
                Forms\Components\TextInput::make('timeline')->disabled(),
                Forms\Components\Textarea::make('message')->disabled()->rows(8)->columnSpanFull(),
            ])->columns(2),
            Forms\Components\Section::make('Workflow')->schema([
                Forms\Components\Select::make('assigned_to')->relationship('assignee', 'name')->searchable()->preload(),
                Forms\Components\Select::make('status')->options(['new' => 'New', 'reviewing' => 'Reviewing', 'quoted' => 'Quoted', 'won' => 'Won', 'lost' => 'Lost'])->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('created_at', 'desc')->columns([
            Tables\Columns\TextColumn::make('name')->description(fn (QuoteRequest $record): string => $record->email)->searchable()->sortable(),
            Tables\Columns\TextColumn::make('company')->searchable(),
            Tables\Columns\TextColumn::make('services')->badge(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                'new' => 'info', 'reviewing' => 'warning', 'won' => 'success', 'lost' => 'danger', default => 'gray'
            }),
            Tables\Columns\TextColumn::make('assignee.name')->label('Assigned to'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(['new' => 'New', 'reviewing' => 'Reviewing', 'quoted' => 'Quoted', 'won' => 'Won', 'lost' => 'Lost']),
            Tables\Filters\SelectFilter::make('assigned_to')->relationship('assignee', 'name')->label('Assigned to'),
        ])->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListQuoteRequests::route('/'), 'edit' => Pages\EditQuoteRequest::route('/{record}/edit')];
    }
}

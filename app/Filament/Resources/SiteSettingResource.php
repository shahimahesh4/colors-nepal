<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = SiteSetting::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Setting')->schema([
                Forms\Components\TextInput::make('key')->required()->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\Select::make('type')
                    ->options(['text' => 'Text', 'textarea' => 'Long text', 'url' => 'URL', 'email' => 'Email', 'image' => 'Image', 'boolean' => 'Enable / disable', 'password' => 'Password / token'])
                    ->required()
                    ->default('text')
                    ->live(),
                Forms\Components\TextInput::make('group')->required()->maxLength(100)->default('general'),
                Forms\Components\Group::make()
                    ->schema(fn (Forms\Get $get): array => $get('type') === 'image'
                        ? [
                            Forms\Components\FileUpload::make('value')
                                ->label('Image')
                                ->image()
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(2048)
                                ->disk('public')
                                ->visibility('public')
                                ->directory('settings')
                                ->imageEditor()
                                ->helperText('PNG, JPG or WebP. Maximum 2 MB.')
                                ->required(),
                        ]
                        : ($get('type') === 'boolean'
                            ? [Forms\Components\Toggle::make('value')->label('Enabled')->onColor('success')->offColor('danger')]
                            : ($get('type') === 'password'
                                ? [Forms\Components\TextInput::make('value')->label('Token')->password()->revealable()]
                                : [
                                    Forms\Components\Textarea::make('value')
                                        ->label('Value')
                                        ->rows(5),
                                ])))
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('key')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('value')->formatStateUsing(fn ($state, SiteSetting $record): string => $record->type === 'password' ? '********' : (string) $state)->limit(50)->searchable(),
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
        return [];
    }
}

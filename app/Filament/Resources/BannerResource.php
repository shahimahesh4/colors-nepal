<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\Concerns\AuthorizesRolePermissions;
use App\Models\Banner;
use App\Services\BannerManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    use AuthorizesRolePermissions;

    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Banners';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Page Banner')
                ->description('Choose the page where this banner will appear. Home has its own separate editor.')
                ->schema([
                    Forms\Components\Select::make('page_key')
                        ->label('Page')
                        ->options(fn (): array => app(BannerManager::class)->pageOptions())
                        ->searchable()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->disabledOn('edit')
                        ->dehydrated(),
                    Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                    Forms\Components\TextInput::make('title')->label('Banner title')->required()->maxLength(255)->columnSpanFull(),
                    Forms\Components\Textarea::make('description')->label('Banner text / description')->rows(4)->maxLength(1000)->columnSpanFull(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Banner image')
                        ->image()
                        ->imagePreviewHeight('220')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(5120)
                        ->disk('public')
                        ->visibility('public')
                        ->directory('banners/pages')
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('1600')
                        ->imageResizeTargetHeight('1000')
                        ->imageResizeUpscale(false)
                        ->imageEditor()
                        ->helperText('Optional. The default banner image is used when empty.')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('button_text')->label('Button text')->maxLength(80),
                    Forms\Components\TextInput::make('button_url')->label('Button link')->placeholder('/contact or https://example.com')->maxLength(2048),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('page_key', '!=', 'home'))
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Image')->disk('public')->defaultImageUrl(asset('storage/'.Banner::DEFAULT_IMAGE))->square(),
                Tables\Columns\TextColumn::make('page_key')->label('Page')->formatStateUsing(fn (string $state): string => app(BannerManager::class)->label($state))->searchable(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(45),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'home' => Pages\ManageHomeBanner::route('/home'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}

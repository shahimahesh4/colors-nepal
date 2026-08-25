<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\PortfolioProjectResource\Pages;
use App\Models\PortfolioProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PortfolioProjectResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = PortfolioProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Project')->schema([
                Forms\Components\Select::make('portfolio_category_id')->relationship('category', 'name')->searchable()->preload(),
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('client_name')->maxLength(255),
                Forms\Components\Textarea::make('summary')->required()->rows(3)->columnSpanFull(),
                Forms\Components\RichEditor::make('content')->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')->image()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120)->disk('public')->visibility('public')->directory('portfolio')->imageResizeMode('contain')->imageResizeTargetWidth('1600')->imageResizeTargetHeight('1200')->imageResizeUpscale(false)->imageEditor(),
                Forms\Components\TagsInput::make('technologies'),
                Forms\Components\TextInput::make('project_url')->url()->maxLength(255),
                Forms\Components\DatePicker::make('completed_at'),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->required()->default('draft'),
                Forms\Components\Toggle::make('is_featured')->default(false),
                Forms\Components\TextInput::make('sort_order')->numeric()->minValue(0)->required()->default(0),
            ])->columns(2),
            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('meta_title')->maxLength(255),
                Forms\Components\Textarea::make('meta_description')->rows(3),
                Forms\Components\TextInput::make('meta_keywords')->helperText('Separate keywords with commas.')->columnSpanFull(),
                Forms\Components\FileUpload::make('og_image')->label('OG image')->image()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120)->disk('public')->visibility('public')->directory('portfolio/og')->imageResizeMode('cover')->imageResizeTargetWidth('1200')->imageResizeTargetHeight('630')->imageResizeUpscale(false)->imageEditor()->helperText('Recommended: 1200 × 630px. Uses the cover image, then the default OG image when empty.'),
            ])->columns(2)->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            Tables\Columns\ImageColumn::make('cover_image')->square(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
            Tables\Columns\IconColumn::make('is_featured')->boolean(),
            Tables\Columns\TextColumn::make('completed_at')->date()->sortable()->toggleable(),
            Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('portfolio_category_id')->relationship('category', 'name')->label('Category'),
            Tables\Filters\SelectFilter::make('status')->options(['draft' => 'Draft', 'published' => 'Published']),
            Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
        ])->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListPortfolioProjects::route('/'), 'create' => Pages\CreatePortfolioProject::route('/create'), 'edit' => Pages\EditPortfolioProject::route('/{record}/edit')];
    }
}

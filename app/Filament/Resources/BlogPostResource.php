<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogPostResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 60;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Article')->schema([
                Forms\Components\Select::make('user_id')->relationship('author', 'name')->searchable()->preload()->label('Author'),
                Forms\Components\Select::make('blog_category_id')->relationship('category', 'name')->searchable()->preload()->label('Category'),
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('excerpt')->required()->rows(3)->columnSpanFull(),
                Forms\Components\RichEditor::make('content')->required()->columnSpanFull(),
                Forms\Components\FileUpload::make('featured_image')->image()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120)->disk('public')->visibility('public')->directory('blog')->imageEditor(),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->required()->default('draft'),
                Forms\Components\DateTimePicker::make('published_at')->seconds(false),
            ])->columns(2),
            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('meta_title')->maxLength(255),
                Forms\Components\Textarea::make('meta_description')->rows(3),
                Forms\Components\TextInput::make('meta_keywords')->helperText('Separate keywords with commas.')->columnSpanFull(),
                Forms\Components\FileUpload::make('og_image')->label('OG image')->image()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120)->disk('public')->visibility('public')->directory('blog/og')->imageEditor()->helperText('Optional. Uses the featured image, then the default OG image when empty.'),
            ])->columns(2)->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('created_at', 'desc')->columns([
            Tables\Columns\ImageColumn::make('featured_image')->square(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),
            Tables\Columns\TextColumn::make('author.name')->label('Author')->toggleable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),
            Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(['draft' => 'Draft', 'published' => 'Published']),
            Tables\Filters\SelectFilter::make('blog_category_id')->relationship('category', 'name')->label('Category'),
        ])->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListBlogPosts::route('/'), 'create' => Pages\CreateBlogPost::route('/create'), 'edit' => Pages\EditBlogPost::route('/{record}/edit')];
    }
}

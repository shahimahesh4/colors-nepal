<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('role')->maxLength(255),
            Forms\Components\TextInput::make('company')->maxLength(255),
            Forms\Components\Select::make('rating')->options([1 => '1 star', 2 => '2 stars', 3 => '3 stars', 4 => '4 stars', 5 => '5 stars'])->required()->default(5),
            Forms\Components\Textarea::make('content')->required()->rows(5)->columnSpanFull(),
            Forms\Components\FileUpload::make('avatar')->image()->avatar()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(2048)->disk('public')->visibility('public')->directory('testimonials'),
            Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->required()->default('draft'),
            Forms\Components\Toggle::make('is_featured')->default(false),
            Forms\Components\TextInput::make('sort_order')->numeric()->minValue(0)->required()->default(0),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort_order')->columns([
            Tables\Columns\ImageColumn::make('avatar')->circular(),
            Tables\Columns\TextColumn::make('name')->description(fn (Testimonial $record): ?string => $record->company)->searchable()->sortable(),
            Tables\Columns\TextColumn::make('rating')->formatStateUsing(fn (int $state): string => "{$state}/5")->sortable(),
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
        return ['index' => Pages\ListTestimonials::route('/'), 'create' => Pages\CreateTestimonial::route('/create'), 'edit' => Pages\EditTestimonial::route('/{record}/edit')];
    }
}

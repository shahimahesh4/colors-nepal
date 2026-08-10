<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\AuthorizesRolePermissions;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    use AuthorizesRolePermissions;
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 90;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('phone')->tel()->maxLength(20)->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('password')->password()->revealable()->required(fn (string $operation): bool => $operation === 'create')->dehydrated(fn (?string $state): bool => filled($state))->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
            Forms\Components\Select::make('role')->options(['admin' => 'Admin', 'staff' => 'Staff', 'customer' => 'Customer'])->default('customer')->required()->helperText('Admins always have full access. Staff and customer access follows Role Permissions.'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('phone')->searchable(),
            Tables\Columns\TextColumn::make('role')->badge()->formatStateUsing(fn (?string $state): string => str($state ?: 'customer')->headline())->color(fn (?string $state): string => match ($state) { 'admin' => 'danger', 'staff' => 'warning', default => 'gray' })->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([Tables\Filters\SelectFilter::make('role')->options(['admin' => 'Admin', 'staff' => 'Staff', 'customer' => 'Customer'])])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListUsers::route('/'), 'create' => Pages\CreateUser::route('/create'), 'edit' => Pages\EditUser::route('/{record}/edit')];
    }
}

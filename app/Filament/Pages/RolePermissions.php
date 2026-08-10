<?php

namespace App\Filament\Pages;

use App\Models\RolePermission;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class RolePermissions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Role Permissions';

    protected static ?string $title = 'Role Permissions';

    protected static ?int $navigationSort = 95;

    protected static string $view = 'filament.pages.role-permissions';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->hasPermission('manage_roles') ?? false;
    }

    public function mount(): void
    {
        abort_unless(static::canAccess(), 403);

        $this->form->fill([
            'staff' => RolePermission::permissionsFor('staff'),
            'customer' => RolePermission::permissionsFor('customer'),
        ]);
    }

    public function form(Form $form): Form
    {
        $options = config('role_permissions.permissions', []);

        return $form
            ->schema([
                Section::make('Admin')
                    ->description('Administrators always have every permission. This prevents accidental lockout.')
                    ->schema([]),
                Section::make('Staff Permissions')
                    ->description('Select what staff members can access and manage in the admin panel.')
                    ->schema([
                        CheckboxList::make('staff')->hiddenLabel()->options($options)->columns(2)->searchable()->bulkToggleable(),
                    ]),
                Section::make('Customer Permissions')
                    ->description('Customers normally use the frontend dashboard. Enable admin access only when required.')
                    ->schema([
                        CheckboxList::make('customer')->hiddenLabel()->options($options)->columns(2)->searchable()->bulkToggleable(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')->label('Save permissions')->icon('heroicon-o-check-circle')->action('save'),
        ];
    }

    public function save(): void
    {
        abort_unless(static::canAccess(), 403);
        $state = $this->form->getState();
        $allowed = array_keys(config('role_permissions.permissions', []));

        foreach (['staff', 'customer'] as $role) {
            $permissions = array_values(array_intersect($state[$role] ?? [], $allowed));
            RolePermission::query()->updateOrCreate(['role' => $role], ['permissions' => $permissions]);
            RolePermission::clearCache($role);
        }

        Notification::make()->title('Role permissions saved')->success()->send();
    }
}

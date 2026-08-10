<?php

namespace Tests\Feature;

use App\Filament\Resources\ServiceResource;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_always_has_every_permission(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($admin->hasPermission('manage_roles'));
        $this->assertTrue($admin->canAccessPanel(filament()->getPanel('admin')));
    }

    public function test_staff_permissions_control_panel_and_resources(): void
    {
        RolePermission::query()->where('role', 'staff')->update([
            'permissions' => ['access_admin_panel', 'manage_services'],
        ]);
        RolePermission::clearCache('staff');
        $staff = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staff);

        $this->assertTrue($staff->canAccessPanel(filament()->getPanel('admin')));
        $this->assertTrue(ServiceResource::canViewAny());
        $this->assertFalse($staff->hasPermission('manage_users'));
    }

    public function test_customer_has_no_admin_access_by_default(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->assertFalse($customer->canAccessPanel(filament()->getPanel('admin')));
        $this->assertFalse($customer->hasPermission('manage_services'));
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AdminNotifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_notifier_creates_unread_notifications_only_for_admins(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->create();

        app(AdminNotifier::class)->send('New enquiry', 'A customer sent an enquiry.', '/stnapanel/contact-messages/1/edit');

        $this->assertSame(1, $admin->unreadNotifications()->count());
        $this->assertSame(0, $customer->notifications()->count());
        $this->assertSame('New enquiry', $admin->unreadNotifications()->first()->data['title']);
    }
}

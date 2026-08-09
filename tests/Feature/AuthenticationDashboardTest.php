<?php

namespace Tests\Feature;

use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_reach_dashboard(): void
    {
        $this->post(route('register'), ['name' => 'Customer One', 'email' => 'customer@example.com', 'password' => 'password123', 'password_confirmation' => 'password123'])->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'customer@example.com', 'is_admin' => false]);
    }

    public function test_customer_can_login_and_logout(): void
    {
        $user = User::factory()->create();
        $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_dashboard_requires_authentication(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_customer_only_opens_their_own_quotes(): void
    {
        $customer = User::factory()->create();
        $other = User::factory()->create();
        $own = QuoteRequest::factory()->create(['user_id' => $customer->id, 'message' => 'My private project details are here.']);
        $foreign = QuoteRequest::factory()->create(['user_id' => $other->id, 'message' => 'Another customer private details.']);
        $this->actingAs($customer)->get(route('dashboard'))->assertOk()->assertSee(implode(', ', $own->services))->assertDontSee('Another customer private details.');
        $this->actingAs($customer)->get(route('dashboard.quotes.show', $own))->assertOk()->assertSee('My private project details are here.');
        $this->actingAs($customer)->get(route('dashboard.quotes.show', $foreign))->assertForbidden();
    }

    public function test_customer_can_update_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->put(route('profile.update'), ['name' => 'Updated Customer', 'email' => 'updated@example.com'])->assertRedirect(route('profile.edit'))->assertSessionHas('success');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Customer', 'email' => 'updated@example.com']);
    }

    public function test_authenticated_quote_submission_is_owned_by_customer(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('quote.store'), ['name' => $user->name, 'email' => $user->email, 'services' => ['SEO'], 'budget' => 'not-sure', 'timeline' => 'Flexible', 'message' => 'I need a practical SEO review for our existing website.', 'consent' => '1'])->assertRedirect(route('quote.create'));
        $this->assertDatabaseHas('quote_requests', ['user_id' => $user->id, 'email' => $user->email]);
    }
}

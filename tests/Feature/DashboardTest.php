<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

final class DashboardTest extends TestCase
{
    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_dashboard(): void
    {
        $user = User::create([
            'name' => 'Commander Shepard',
            'username' => 'shepard',
            'email' => 'shepard@normandy.com',
            'password' => 'password123',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk()
            ->assertSee('Dashboard Overview')
            ->assertSee('Total Revenue')
            ->assertSee('Recent Registered Users');
    }
}

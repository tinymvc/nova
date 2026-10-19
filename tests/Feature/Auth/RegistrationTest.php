<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

final class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertOk()
            ->assertSee('Create an account');
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Alice Artisan',
            'username' => 'aliceartisan',
            'email' => 'alice@example.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'username' => 'aliceartisan',
            'email' => 'alice@example.com',
        ]);
    }

    public function test_registration_requires_matching_password_confirmation(): void
    {
        $this->post('/register', [
            'name' => 'Alice Artisan',
            'username' => 'aliceartisan',
            'email' => 'alice@example.com',
            'password' => 'secret1234',
            'password_confirmation' => 'different-password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseMissing('users', [
            'email' => 'alice@example.com',
        ]);
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        User::create([
            'name' => 'Existing User',
            'username' => 'existinguser',
            'email' => 'existing@example.com',
            'password' => 'secret1234',
        ]);

        $this->post('/register', [
            'name' => 'Duplicate User',
            'username' => 'dupuser',
            'email' => 'existing@example.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $this->assertGuest();
        $this->assertDatabaseMissing('users', [
            'username' => 'dupuser',
        ]);
    }
}

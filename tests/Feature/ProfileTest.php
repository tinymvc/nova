<?php

namespace Tests\Feature;

use App\Models\User;
use Spark\Facades\Hash;
use Tests\TestCase;

final class ProfileTest extends TestCase
{
    public function test_guests_cannot_view_profile(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_profile(): void
    {
        $user = User::create([
            'name' => 'Garrus Vakarian',
            'username' => 'archangel',
            'email' => 'garrus@normandy.com',
            'password' => 'secret1234',
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk()
            ->assertSee('Profile Settings')
            ->assertSee('Garrus Vakarian')
            ->assertSee('garrus@normandy.com');
    }

    public function test_users_can_update_profile_information(): void
    {
        $user = User::create([
            'name' => 'Garrus Vakarian',
            'username' => 'archangel',
            'email' => 'garrus@normandy.com',
            'password' => 'secret1234',
        ]);

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'Garrus C. Vakarian',
            'username' => 'archangel_prime',
            'email' => 'garrus.updated@normandy.com',
        ]);

        $response->assertStatus(302);

        $freshUser = User::where('id', $user->id)->first();
        $this->assertSame('Garrus C. Vakarian', $freshUser->name);
        $this->assertSame('archangel_prime', $freshUser->username);
        $this->assertSame('garrus.updated@normandy.com', $freshUser->email);
    }

    public function test_password_update_requires_matching_current_password(): void
    {
        $user = User::create([
            'name' => 'Garrus Vakarian',
            'username' => 'archangel',
            'email' => 'garrus@normandy.com',
            'password' => 'secret1234',
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'name' => 'Garrus Vakarian',
            'username' => 'archangel',
            'email' => 'garrus@normandy.com',
            'current_password' => 'wrong-current-password',
            'password' => 'brandnewpassword123',
            'password_confirmation' => 'brandnewpassword123',
        ]);

        $response->assertStatus(302);

        $freshUser = User::where('id', $user->id)->first();
        $this->assertTrue(Hash::verify('secret1234', $freshUser->password));
    }

    public function test_users_can_update_password_with_correct_current_password(): void
    {
        $user = User::create([
            'name' => 'Garrus Vakarian',
            'username' => 'archangel',
            'email' => 'garrus@normandy.com',
            'password' => 'secret1234',
        ]);

        $response = $this->actingAs($user)->put('/password', [
            'name' => 'Garrus Vakarian',
            'username' => 'archangel',
            'email' => 'garrus@normandy.com',
            'current_password' => 'secret1234',
            'password' => 'brandnewpassword123',
            'password_confirmation' => 'brandnewpassword123',
        ]);

        $response->assertStatus(302);

        $freshUser = User::where('id', $user->id)->first();
        $this->assertTrue(Hash::verify('brandnewpassword123', $freshUser->password));
    }
}

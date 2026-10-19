<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Spark\Facades\DB;
use Spark\Facades\Hash;
use Tests\TestCase;

final class PasswordResetTest extends TestCase
{
    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertOk()
            ->assertSee('Forgot password?');
    }

    public function test_reset_password_link_can_be_requested_for_existing_user(): void
    {
        User::create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => 'secret1234',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'jane@example.com',
        ]);

        $response->assertStatus(302);

        $record = DB::table('password_reset_tokens')->where('email', 'jane@example.com')->first();
        $this->assertNotNull($record);
        $this->assertNotEmpty($record->token);
    }

    public function test_reset_password_link_for_nonexistent_user_does_not_reveal_presence(): void
    {
        $response = $this->post('/forgot-password', [
            'email' => 'nobody@example.com',
        ]);

        $response->assertStatus(302);

        $record = DB::table('password_reset_tokens')->where('email', 'nobody@example.com')->first();
        $this->assertNull($record);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $response = $this->get('/reset-password/sample-token?email=jane@example.com');

        $response->assertOk()
            ->assertSee('Reset Password')
            ->assertSee('sample-token');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => 'oldpassword123',
        ]);

        $token = 'valid-reset-token-12345';

        DB::table('password_reset_tokens')->insert([
            'email' => 'jane@example.com',
            'token' => $token,
            'created_at' => now()->toDateTimeString(),
        ]);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'jane@example.com',
            'password' => 'brandnewpassword',
            'password_confirmation' => 'brandnewpassword',
        ]);

        $response->assertRedirect(route('login'));

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertTrue(Hash::verify('brandnewpassword', $user->password));

        // Single-use token must be deleted
        $record = DB::table('password_reset_tokens')->where('email', 'jane@example.com')->first();
        $this->assertNull($record);
    }

    public function test_password_cannot_be_reset_with_invalid_token(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => 'oldpassword123',
        ]);

        $response = $this->post('/reset-password', [
            'token' => 'invalid-token',
            'email' => 'jane@example.com',
            'password' => 'brandnewpassword',
            'password_confirmation' => 'brandnewpassword',
        ]);

        $response->assertStatus(302);

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertTrue(Hash::verify('oldpassword123', $user->password));
    }

    public function test_password_cannot_be_reset_with_expired_token(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => 'oldpassword123',
        ]);

        $token = 'expired-token-12345';

        // Insert token created 2 hours ago (> 60 minutes)
        DB::table('password_reset_tokens')->insert([
            'email' => 'jane@example.com',
            'token' => $token,
            'created_at' => now()->subHours(2)->toDateTimeString(),
        ]);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'jane@example.com',
            'password' => 'brandnewpassword',
            'password_confirmation' => 'brandnewpassword',
        ]);

        $response->assertStatus(302);

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertTrue(Hash::verify('oldpassword123', $user->password));
    }
}

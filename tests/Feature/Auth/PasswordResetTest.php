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
            'token' => hash('sha256', $token),
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
            'token' => hash('sha256', $token),
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
    public function test_generated_reset_links_use_hashed_single_use_tokens(): void
    {
        User::create([
            'name' => 'Nova Builder',
            'username' => 'builder',
            'email' => 'builder@example.com',
            'password' => 'original-password',
        ]);

        $mail = new class extends \Spark\Utils\Mail {
            public string $token = '';

            public function send(): bool
            {
                preg_match('~/reset-password/([a-zA-Z0-9]+)~', $this->Body, $matches);
                $this->token = $matches[1] ?? '';

                return true;
            }
        };

        app()->instance(\Spark\Utils\Mail::class, $mail);

        $this->post('/forgot-password', ['email' => 'builder@example.com'])->assertStatus(302);

        $record = DB::table('password_reset_tokens')->where('email', 'builder@example.com')->first();
        $this->assertSame(64, strlen($mail->token));
        $this->assertSame(hash('sha256', $mail->token), $record->token);

        $data = [
            'email' => 'builder@example.com',
            'token' => $mail->token,
            'password' => 'replacement-password',
            'password_confirmation' => 'replacement-password',
        ];

        $this->post('/reset-password', $data)->assertRedirect(route('login'));
        $this->postJson('/reset-password', $data)->assertJsonValidationErrors('email');
        $this->assertDatabaseCount('password_reset_tokens', 0);
    }

    public function test_failed_delivery_does_not_report_success_or_leave_a_token(): void
    {
        User::create([
            'name' => 'Nova Builder',
            'username' => 'builder',
            'email' => 'builder@example.com',
            'password' => 'original-password',
        ]);

        app()->instance(\Spark\Utils\Mail::class, new class extends \Spark\Utils\Mail {
            public function send(): bool
            {
                return false;
            }
        });

        $this->postJson('/forgot-password', ['email' => 'builder@example.com'], ['X-FireLine' => '1'])
            ->assertStatus(503)
            ->assertJsonPath('status', 'error');

        $this->assertDatabaseCount('password_reset_tokens', 0);
    }

}

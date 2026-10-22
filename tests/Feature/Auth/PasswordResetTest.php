<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Spark\Facades\DB;
use Spark\Facades\Hash;
use Spark\Facades\Queue;
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

        $response->assertOk()->assertJsonPath('status', 'success');

        $record = DB::table('password_reset_tokens')->where('email', 'jane@example.com')->first();
        $this->assertNotNull($record);
        $this->assertNotEmpty($record->token);
    }

    public function test_reset_password_link_for_nonexistent_user_does_not_reveal_presence(): void
    {
        $response = $this->post('/forgot-password', [
            'email' => 'nobody@example.com',
        ]);

        $response->assertOk()->assertJsonPath('status', 'success');

        $record = DB::table('password_reset_tokens')->where('email', 'nobody@example.com')->first();
        $this->assertNull($record);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $response = $this->get('/reset-password/sample-token');

        $response->assertOk()
            ->assertSee('Reset Password')
            ->assertSee('sample-token')
            ->assertDontSee('name="email"')
            ->assertDontSee('Email address');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        User::create([
            'name' => 'Other User',
            'username' => 'other',
            'email' => 'other@example.com',
            'password' => 'other-password',
        ]);

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
            'password' => 'brandnewpassword',
            'password_confirmation' => 'brandnewpassword',
        ]);

        $response->assertRedirect(route('login'));

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertTrue(Hash::verify('brandnewpassword', $user->password));

        $other = User::where('email', 'other@example.com')->first();
        $this->assertTrue(Hash::verify('other-password', $other->password));

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

        $response = $this->postJson('/reset-password', [
            'token' => 'invalid-token',
            'password' => 'brandnewpassword',
            'password_confirmation' => 'brandnewpassword',
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors('token');

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

        $response = $this->postJson('/reset-password', [
            'token' => $token,
            'password' => 'brandnewpassword',
            'password_confirmation' => 'brandnewpassword',
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors('token');

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

        $this->postJson('/forgot-password', ['email' => 'builder@example.com'], ['X-FireLine' => '1'])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        Queue::work(once: true, sleep: 0);

        $record = DB::table('password_reset_tokens')->where('email', 'builder@example.com')->first();
        $this->assertSame(64, strlen($mail->token));
        $this->assertSame(hash('sha256', $mail->token), $record->token);
        $this->assertStringNotContainsString('?email=', $mail->Body);

        $page = $this->get('/reset-password/' . $mail->token, ['X-FireLine' => '1'])
            ->assertOk();
        $this->assertStringNotContainsString('name="email"', $page->json('html'));

        $data = [
            'token' => $mail->token,
            'password' => 'replacement-password',
            'password_confirmation' => 'replacement-password',
        ];

        $this->postJson('/reset-password', $data, ['X-FireLine' => '1'])
            ->assertOk()
            ->assertJsonPath('navigate', (string) route('login'));
        $this->postJson('/reset-password', $data, ['X-FireLine' => '1'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('token');
        $this->assertDatabaseCount('password_reset_tokens', 0);

        $user = User::where('email', 'builder@example.com')->first();
        $this->assertTrue(Hash::verify('replacement-password', $user->password));
    }

    public function test_failed_queued_delivery_removes_the_token_after_exhausting_retries(): void
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
            ->assertOk()
            ->assertJsonPath('status', 'success');

        Queue::work(once: true, sleep: 0, tries: 1);

        $this->assertDatabaseCount('password_reset_tokens', 0);
    }

    public function test_reset_still_requires_a_token_and_confirmed_password(): void
    {
        $this->postJson('/reset-password', [
            'password' => 'replacement-password',
            'password_confirmation' => 'replacement-password',
        ], ['X-FireLine' => '1'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('token');

        $this->postJson('/reset-password', [
            'token' => 'sample-token',
            'password' => 'replacement-password',
            'password_confirmation' => 'different-password',
        ], ['X-FireLine' => '1'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('password');
    }

}

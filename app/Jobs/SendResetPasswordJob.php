<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\PasswordResetService;
use Spark\Database\DB;
use Spark\Facades\Log;
use Spark\Queue\Contracts\JobInterface;
use Spark\Queue\Dispatchable;

class SendResetPasswordJob implements JobInterface
{
    use Dispatchable;

    protected int $tries = 2;

    protected array $backoff = [60, 120];

    public function __construct(
        public readonly int $userId,
        public readonly string $token,
        public readonly string $digest,
    ) {
    }

    public function handle(PasswordResetService $passwordResetService): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            return; // User not found, exit the job gracefully
        }

        $passwordResetService->sendResetEmail($user, $this->token);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error(\sprintf(
            'Failed to send password reset email for user ID %d: %s',
            $this->userId,
            $exception->getMessage()
        ));

        $email = User::whereKey($this->userId)->value('email');

        if (!$email) {
            return; // User not found, exit the job gracefully
        }

        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $this->digest)
            ->delete();
    }
}

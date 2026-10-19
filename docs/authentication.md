# Nova Authentication Architecture & Flows

Nova provides a complete, production-grade authentication implementation built natively on the **TinyMVC / Spark** core framework engine. It avoids unnecessary third-party packages and leverages Spark's built-in session, authentication, validation, and database subsystems.

---

## 1. Authentication Architecture

```
┌─────────────────┐       ┌────────────────────────┐       ┌─────────────────┐
│  Client Request │  ──>  │ Middleware Pipeline    │  ──>  │ Controller      │
│  (Browser/SPA)  │       │ (CSRF, Guest/Auth,     │       │ Action          │
└─────────────────┘       │  Throttle)             │       └────────┬────────┘
                                                                    │
                                   ┌────────────────────────────────┼────────────────────────────────┐
                                   ▼                                ▼                                ▼
                       ┌───────────────────────┐        ┌───────────────────────┐        ┌───────────────────────┐
                       │ Spark\Http\Auth       │        │ App\Models\User       │        │ Spark\Facades\DB      │
                       │ (Session / Guards)    │        │ (Argon2id Passwords)  │        │ (Reset Tokens Table)  │
                       └───────────────────────┘        └───────────────────────┘        └───────────────────────┘
```

### Components
- **Controllers** (`app/Http/Controllers/Auth/`):
  - `AuthenticatedSessionController`: Login page, authentication execution, and logout.
  - `RegisteredUserController`: Registration page and account provisioning.
  - `PasswordResetLinkController`: Requesting password reset tokens and email dispatching.
  - `NewPasswordController`: Reset password token verification and password updates.
- **Form Requests** (`app/Http/Requests/Auth/`):
  - Dedicated validation rules and custom error messages for each action.
- **Model** (`app/Models/User.php`):
  - Password casting (`'password' => 'hashed'`) with automatic Argon2id or Bcrypt hashing.
- **Database Tables**:
  - `users`: User account records with unique `email` and `username`.
  - `password_reset_tokens`: Transient reset tokens with timestamp tracking.

---

## 2. Authentication Flows

### A. Sign In (`POST /login`)
1. User submits `email`, `password`, and optional `remember`.
2. `LoginRequest` validates required fields and email formatting.
3. Route is protected by the `throttle:10,1` middleware (maximum 10 attempts per minute per IP).
4. `Auth::attempt(['email' => $email, 'password' => $password], $remember)` checks credentials.
5. On success:
   - Session fixation protection: `session()->regenerate()`.
   - User is redirected to `route('dashboard')` or their intended URL.
6. On failure:
   - Request is redirected back with input (excluding password) and validation error: `"These credentials do not match our records."`.

### B. Sign Out (`POST /logout`)
1. Only accessible by authenticated users (`middleware: 'auth'`).
2. Requires valid CSRF token.
3. Session invalidation: `session()->invalidate()`.
4. Redirects safely to the landing page `/`.

### C. Registration (`POST /register`)
1. User submits `name`, `username`, `email`, `password`, and `password_confirmation`.
2. `RegisterRequest` enforces:
   - `username`: unique, alphanumeric with dashes, minimum 3 characters.
   - `email`: unique in `users` table, valid format.
   - `password`: minimum 8 characters, matching confirmation.
3. `User::create([...])` hashes the password securely using Spark's configured algorithm.
4. `Auth::login($user)` establishes the new session immediately.
5. `session()->regenerate()` secures the new session.
6. Redirects to `route('dashboard')`.

### D. Forgot Password Request (`POST /forgot-password`)
1. User provides registered email address.
2. Rate-limited via `throttle:5,1` (maximum 5 requests per minute).
3. If an account matches:
   - An unguessable, cryptographically secure 64-character token is generated: `Str::random(64)`.
   - Existing tokens for the email are deleted from `password_reset_tokens`.
   - The token and timestamp are stored in `password_reset_tokens`.
   - A notification email with the reset link is sent via Spark's `Mail` facade using the `emails.password-reset` Blade template.
4. **User Enumeration Prevention**: Even if the email does not exist, the controller returns the identical generic flash message:
   `"If an account exists for that email, a password reset link has been sent."`

### E. Password Reset Execution (`POST /reset-password`)
1. User clicks the email link to view `/reset-password/{token}?email=...`.
2. User enters new password and confirmation.
3. Controller verifies:
   - Token exists in `password_reset_tokens` for the specified email.
   - **Token Expiry**: The token is verified to be within 60 minutes (`Carbon::parse($record->created_at)->addMinutes(60)->isPast()`). If expired, it is deleted and an error is returned.
4. The user's password attribute is updated and rehashed.
5. **Single-Use Enforcement**: The reset token is immediately purged from the database upon successful update.
6. User is redirected to `/login` with a success status message.

---

## 3. Middleware & Route Protection

All routes in `routes/web.php` are organized into two semantic groups:

```php
// Guest-only routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email')->middleware('throttle:5,1');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Authenticated application routes
Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
```

- **`GuestMiddleware`**: Inspects `Auth::check()`. If the user is already authenticated, they are redirected to `route('dashboard')`.
- **`AuthMiddleware`**: Inspects `Auth::check()`. If the user is not signed in, their attempted URL is recorded and they are redirected to `route('login')`.

---

## 4. Security Hardening Checklist

| Feature | Implementation | Purpose |
| --- | --- | --- |
| **Password Hashing** | `Argon2id` (memory_cost: 65536, time_cost: 4, threads: 2) | Resistant to GPU brute-force attacks |
| **Session Fixation** | `session()->regenerate()` | Invalidates previous session ID upon login & register |
| **Session Cleanup** | `session()->invalidate()` | Clears sensitive session data upon logout |
| **CSRF Defense** | `@csrf` directive & `CsrfProtectionMiddleware` | Validates secret token on all state-changing verbs (POST/PUT/PATCH/DELETE) |
| **Rate Limiting** | `throttle:10,1` and `throttle:5,1` | Thwarts credential-stuffing and brute-force attacks |
| **Reset Expiry** | 60 minutes TTL | Closes exposure window for password reset tokens |
| **Single-Use Tokens** | Immediate deletion on consumption | Prevents token replay attacks |
| **Safe Error Messages** | Generic status message on password reset request | Prevents account enumeration |
| **Current Password Verification** | `Hash::verify($currentPassword, $user->password)` | Prevents unauthorized password changes from open sessions |

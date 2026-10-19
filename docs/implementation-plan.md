# Nova Implementation Plan

This document details the multi-phase roadmap for delivering the **Nova** starter kit for TinyMVC / Spark.

---

## Phase 1: Repository Discovery and Architecture

- [x] Load and inspect the installed framework skill (`vendor/tinymvc/tinycore/skills/tinymvc-spark/SKILL.md`).
- [x] Inspect existing skeleton files, database migrations, configuration, and Vite configuration.
- [x] Verify FireLine PHP adapter requirements and installation (`tinymvc/fireline-php`).
- [x] Analyze Blade compiler component syntax, attribute parsing, props extraction, and slot processing.
- [x] Establish architecture decisions, security standards, and directory conventions in `docs/architecture.md`.
- [x] Define phased acceptance criteria and test verification requirements.

---

## Phase 2: Frontend Foundation

### Objectives
Integrate Tailwind CSS 4, daisyUI 5, Alpine.js 3, FireLine 2.1, and Vite into a coherent build pipeline.

### Proposed Changes
1. **Dependencies (`package.json`)**:
   - Add `daisyui` (v5 for Tailwind 4).
   - Add `fireline` (v2.1 for Alpine.js).
   - Ensure clean lockfile generation via `npm.cmd install`.
2. **CSS Entrypoint (`resources/app/app.css`)**:
   - Configure Tailwind 4 directives with daisyUI plugin:
     ```css
     @import "tailwindcss";
     @plugin "daisyui";

     @source '../views/**/*.blade.php';
     @source '../views/**/*.php';
     @source './**/*.js';
     ```
   - Define custom focus styles, theme tokens, and smooth scrolling.
3. **JS Entrypoint (`resources/app/app.js`)**:
   - Import Alpine.js and FireLine plugin.
   - Register `Alpine.plugin(FireLine)`.
   - Configure `axios` defaults (`X-Requested-With`).
   - Start Alpine with `Alpine.start()`.
4. **Vite Configuration (`vite.config.js`)**:
   - Verify `@tailwindcss/vite` plugin and full reload for Blade files.
5. **Asset Build Verification**:
   - Run `npm.cmd run build` and ensure output files are written to `public/build/` with a valid manifest.

### Acceptance Criteria
- `npm.cmd run build` succeeds without warnings or errors.
- Generated CSS contains compiled daisyUI component styles and Tailwind utility classes.
- Alpine.js and FireLine initialize without console errors.

---

## Phase 3: Reusable Blade Components

### Objectives
Develop a rich library of reusable, accessible Blade components adhering to Spark's `<x-component>` architecture in `resources/views/components/`.

### Proposed Components

| Category | Component Name | Props / Features | daisyUI Base |
| --- | --- | --- | --- |
| **Actions** | `<x-button>` | `type`, `variant` (primary, secondary, accent, neutral, ghost, error, outline), `size` (xs, sm, md, lg), `loading` (bool), `icon` | `.btn`, `.btn-*` |
| | `<x-link>` | `href`, `variant` (primary, neutral, hover, error), `external` (bool) | `.link`, `.link-*` |
| | `<x-icon>` | `name` (heroicons-style SVGs: dashboard, users, key, lock, mail, chevron-*, check, x, alert, search, sun, moon), `size` (sm, md, lg), `class` | SVG icon |
| | `<x-divider>` | `label` (optional text in separator), `vertical` (bool) | `.divider` |
| **Form Controls** | `<x-input>` | `name`, `label`, `type`, `value`, `placeholder`, `required`, `disabled`, `readonly`, `icon`, `help` | `.input`, `.input-bordered` |
| | `<x-textarea>` | `name`, `label`, `value`, `rows`, `placeholder`, `required`, `disabled`, `help` | `.textarea`, `.textarea-bordered` |
| | `<x-select>` | `name`, `label`, `options` (array/slot), `selected`, `placeholder`, `required`, `help` | `.select`, `.select-bordered` |
| | `<x-checkbox>` | `name`, `label`, `checked` (bool), `value`, `disabled`, `help` | `.checkbox`, `.checkbox-*` |
| | `<x-radio>` | `name`, `label`, `value`, `checked` (bool), `disabled` | `.radio`, `.radio-*` |
| | `<x-toggle>` | `name`, `label`, `checked` (bool), `value`, `disabled` | `.toggle`, `.toggle-*` |
| | `<x-label>` | `for`, `value` (slot or text), `required` (bool) | `.label`, `.label-text` |
| | `<x-help>` | `text` (slot or prop) | `.label-text-alt` |
| | `<x-error>` | `field`, `message` (explicit or extracted from session error bag) | `.text-error`, `.text-xs` |
| **Data & Feedback** | `<x-card>` | `title`, `subtitle`, `bordered` (bool), `shadow` (sm, md, lg), `actions` (slot), `$slot` | `.card`, `.card-body` |
| | `<x-badge>` | `variant` (primary, secondary, success, warning, error, info, neutral, ghost), `size`, `outline` | `.badge`, `.badge-*` |
| | `<x-avatar>` | `src`, `name` (initials fallback), `size` (xs, sm, md, lg), `shape` (circle, squircle), `status` (online, offline) | `.avatar`, `.avatar-placeholder` |
| | `<x-alert>` | `type` (info, success, warning, error), `message` (prop/slot), `dismissible` (bool), `icon` | `.alert`, `.alert-*` |
| | `<x-flash>` | Reads `session('status')`, `session('success')`, `session('error')`, `session('warning')` | Automatic alert |
| | `<x-modal>` | `id`, `title`, `trigger` (slot), `actions` (slot), `maxWidth` (sm, md, lg, xl, 2xl) | `<dialog class="modal">` + Alpine |
| | `<x-confirm-dialog>`| `id`, `title`, `message`, `confirmText`, `cancelText`, `action`, `method` | Destructive action confirmation |
| | `<x-dropdown>` | `align` (left, right), `trigger` (slot), `content` (slot) | `.dropdown`, `.dropdown-content` |
| | `<x-tooltip>` | `text`, `position` (top, bottom, left, right), `$slot` | `.tooltip`, `.tooltip-*` |
| | `<x-table>` | `striped` (bool), `hover` (bool), `head` (slot), `$slot` | `.table`, `.table-zebra` |
| | `<x-pagination>` | `paginator` (`Spark\Utils\Paginator`) | `.join`, `.btn` page links |
| | `<x-empty-state>`| `icon`, `title`, `description`, `action` (slot) | Centered illustration/card |
| | `<x-loading>` | `type` (spinner, dots, ring, ball), `size` (xs, sm, md, lg) | `.loading`, `.loading-*` |
| | `<x-skeleton>` | `type` (text, title, circle, rectangle), `count` | `.skeleton` |
| **Navigation** | `<x-page-header>` | `title`, `description`, `breadcrumbs` (array/slot), `actions` (slot) | Responsive flex header |
| | `<x-breadcrumb>` | `items` (array of `['label' => ..., 'url' => ...]`) | `.breadcrumbs` |

### Acceptance Criteria
- Every component defines clean defaults via `@props`.
- Extra attributes forward cleanly using `$attributes->merge()` or `$attributes->class()`.
- Content is safely escaped by default.
- Components render in both full MPA and FireLine partial requests.

---

## Phase 4: Authentication Implementation

### Objectives
Build secure, idiomatic authentication flows using native Spark facilities.

### Proposed Files & Routes
1. **Controllers**:
   - `App\Http\Controllers\Auth\AuthenticatedSessionController`: `create`, `store`, `destroy`.
   - `App\Http\Controllers\Auth\RegisteredUserController`: `create`, `store`.
   - `App\Http\Controllers\Auth\PasswordResetLinkController`: `create`, `store`.
   - `App\Http\Controllers\Auth\NewPasswordController`: `create`, `store`.
2. **FormRequests**:
   - `App\Http\Requests\Auth\LoginRequest`: validates `email`, `password`, `remember`.
   - `App\Http\Requests\Auth\RegisterRequest`: validates `name`, `username`, `email` (unique), `password` (confirmed, min:8).
   - `App\Http\Requests\Auth\ForgotPasswordRequest`: validates `email`.
   - `App\Http\Requests\Auth\ResetPasswordRequest`: validates `token`, `email`, `password` (confirmed, min:8).
3. **Middleware**:
   - `App\Http\Middlewares\GuestMiddleware`: redirects authenticated users to `route('dashboard')`.
   - Update `App\Http\Middlewares\AuthMiddleware`: redirects unauthenticated web users to `route('login')`.
4. **Service Provider**:
   - Register `\Spark\Fire\FireServiceProvider::class` in `bootstrap/providers.php`.
   - Register `\Spark\Fire\FireMiddleware::class` in `bootstrap/app.php`.
5. **Views**:
   - `resources/views/auth/login.blade.php`
   - `resources/views/auth/register.blade.php`
   - `resources/views/auth/forgot-password.blade.php`
   - `resources/views/auth/reset-password.blade.php`
   - `resources/views/emails/password-reset.blade.php`
6. **Routes (`routes/web.php`)**:
   - `GET /login` -> `AuthenticatedSessionController@create` (`login`) [guest]
   - `POST /login` -> `AuthenticatedSessionController@store` [guest, throttle:10,1]
   - `POST /logout` -> `AuthenticatedSessionController@destroy` (`logout`) [auth]
   - `GET /register` -> `RegisteredUserController@create` (`register`) [guest]
   - `POST /register` -> `RegisteredUserController@store` [guest]
   - `GET /forgot-password` -> `PasswordResetLinkController@create` (`password.request`) [guest]
   - `POST /forgot-password` -> `PasswordResetLinkController@store` (`password.email`) [guest, throttle:5,1]
   - `GET /reset-password/{token}` -> `NewPasswordController@create` (`password.reset`) [guest]
   - `POST /reset-password` -> `NewPasswordController@store` (`password.update`) [guest]

### Security Checklist
- `Session::regenerate()` after login.
- `Session::invalidate()` and `Auth::logout()` on logout.
- Cryptographically secure 64-char token for password reset.
- Token expires in 60 minutes.
- Immediate token deletion upon reset.
- Passwords hashed with `Hash::make()` / model cast.
- Rate limiting on login and forgot-password endpoints.

### Acceptance Criteria
- Guest users can register and are immediately authenticated.
- Registered users can log in with valid credentials; invalid credentials produce validation errors.
- Password reset token is created, verified, and consumed.
- Unauthenticated access to protected routes redirects to `/login`.
- Authenticated access to `/login` or `/register` redirects to `/dashboard`.

---

## Phase 5: Layouts and Admin Dashboard

### Objectives
Provide responsive, accessible layouts and an interactive administrative dashboard with realistic demonstration data.

### Proposed Files
1. **Layout Components**:
   - `resources/views/components/layouts/guest.blade.php`: Header with logo and theme toggle, clean centered container, footer links.
   - `resources/views/components/layouts/auth.blade.php`: Centered card with application branding for sign in, sign up, and recovery.
   - `resources/views/components/layouts/app.blade.php`: Full dashboard shell:
     - Top navigation bar with breadcrumbs, notifications bell, user dropdown with profile link & logout form.
     - Collapsible desktop sidebar with active route indicator.
     - Mobile navigation drawer toggleable via Alpine.js (`open: false`).
     - Main content slot with flash notification container (`<x-flash />`).
2. **Dashboard Controller & View**:
   - `App\Http\Controllers\DashboardController`: provides labeled demonstration metrics.
   - `resources/views/dashboard/index.blade.php`:
     - 4 KPI metric cards (Total Revenue, Active Users, Conversions, Server Uptime).
     - Recent Activity timeline with status badges.
     - Recent Orders / Users data table with pagination sample.
     - Quick action buttons (New User, Generate Report, System Settings).

### Acceptance Criteria
- Dashboard adapts seamlessly across mobile (375px), tablet (768px), and desktop (1280px+).
- Active navigation items automatically highlight based on the current route.
- Interactive user dropdown reveals user name, email, profile link, and logout button.

---

## Phase 6: Profile & Extension Points

### Objectives
Provide user profile management and document modular expansion points.

### Proposed Files
1. **Controller**:
   - `App\Http\Controllers\ProfileController`: `edit` and `update`.
2. **FormRequest**:
   - `App\Http\Requests\ProfileUpdateRequest`: validates `name`, `username`, `email` (unique ignore current user), and optional password change (`current_password`, `new_password` confirmed).
3. **View**:
   - `resources/views/profile/edit.blade.php`: Profile details form, Password update form, Account security overview.
4. **Routes**:
   - `GET /profile` -> `ProfileController@edit` (`profile.edit`) [auth]
   - `PATCH /profile` -> `ProfileController@update` (`profile.update`) [auth]

### Acceptance Criteria
- User can change their display name, email, and password.
- Password change validates current password before applying new hash.
- Changes persist to SQLite database.

---

## Phase 7: Testing & Verification

### Objectives
Build a comprehensive automated test suite utilizing TinyMVC's native test runner (`php test`).

### Test Suites to Create
- `tests/Feature/Auth/AuthenticationTest.php`:
  - Login page renders.
  - User can authenticate with valid credentials.
  - User cannot authenticate with invalid password.
  - User can log out.
  - Session regenerates on login.
- `tests/Feature/Auth/RegistrationTest.php`:
  - Registration page renders.
  - New user can register.
  - Duplicate email or username is rejected with validation errors.
- `tests/Feature/Auth/PasswordResetTest.php`:
  - Forgot password page renders.
  - Reset token generated and stored in `password_reset_tokens`.
  - Expired token is rejected.
  - Password can be reset and token is destroyed.
- `tests/Feature/DashboardTest.php`:
  - Guests cannot access dashboard (redirected to `/login`).
  - Authenticated user can view dashboard.
- `tests/Feature/ProfileTest.php`:
  - Profile page displays user information.
  - Profile details can be updated.
  - Password update verifies current password.
- `tests/Feature/ComponentTest.php`:
  - Blade components (`button`, `alert`, `input`, `badge`, `modal`) compile and render expected HTML attributes and slots.

### Acceptance Criteria
- `php test` runs with 100% passing assertions.
- `npm.cmd run build` executes cleanly with valid manifest generation.

---

## Phase 8: Documentation & Release

### Objectives
Deliver production-grade documentation for installation, component usage, and customization.

### Deliverables
- `README.md`: Quick-start guide, requirements, installation commands, stack summary.
- `.env.example`: Safe configuration template.
- `docs/architecture.md`: Architectural reference.
- `docs/implementation-plan.md`: Implementation record.
- `docs/components.md`: Complete API reference for all Blade components with props and copy-pasteable examples.
- `docs/authentication.md`: Authentication flow, security mechanisms, and password reset documentation.
- `CHANGELOG.md`: Release notes for Nova v1.0.0.

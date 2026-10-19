# Changelog

All notable changes to the **Nova** starter kit will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] - 2026-10-19

### Added
- **Frontend Architecture**:
  - Tailwind CSS 4 with `@import "tailwindcss"` and DaisyUI 5 plugin integration.
  - Alpine.js 3 integrated with FireLine 2.1 for seamless SPA-like page transitions (`x-navigate`).
  - Vite 7 build configuration with automated manifest emission and Blade `@vite` directive integration.
- **Blade Component Library (25+ components)**:
  - `button`: Multi-variant, accessible button with loading and icon states.
  - `link`: Semantic anchor tag with hover states and `x-navigate` support.
  - `icon`: 25+ accessible inline SVG Heroicons.
  - `divider`: Horizontal and vertical separator with centered label.
  - `breadcrumb`: Navigation trail component with icon support.
  - `page-header`: Consistent header with title, description, and action button slot.
  - `label`, `help`, `error`: Semantic form field labeling, contextual help, and automated validation error display.
  - `input`: Text/email/password inputs with built-in show/hide password toggle.
  - `textarea`, `select`, `checkbox`, `radio`, `toggle`: Complete form control suite.
  - `card`, `badge`, `avatar`, `alert`, `flash`: Data display and status feedback components.
  - `modal`, `confirm-dialog`, `dropdown`, `tooltip`: Interactive DaisyUI/Alpine overlays.
  - `table`, `pagination`, `empty-state`, `loading`, `skeleton`: Data layout and state handling components.
- **Authentication System**:
  - Secure login flow with rate limiting (`throttle:10,1`) and session regeneration.
  - Logout flow with complete session invalidation.
  - User registration with unique username and email constraints.
  - Forgot password flow with user enumeration protection and email notification.
  - Expiring (60 min), single-use password reset tokens with immediate destruction upon use.
  - Argon2id / Bcrypt password hashing via Spark model casts (`'password' => 'hashed'`).
  - `GuestMiddleware` and `AuthMiddleware` route protection.
- **Layouts & Dashboard**:
  - `layouts.app`: Authenticated application shell with responsive mobile sidebar drawer and user navigation.
  - `layouts.auth`: Centered card layout for authentication flows.
  - `layouts.guest`: Public landing layout with header and footer.
  - Admin dashboard overview featuring live statistic metric cards, recent activity stream, recent records table, and project creation modal.
- **User Profile Management**:
  - Profile detail editing (name, username, email).
  - Password updating with mandatory current password verification.
- **Automated Testing Suite**:
  - 33 automated tests with 93 assertions covering authentication, authorization, registration, password resets, profile management, and Blade component rendering.
- **Documentation**:
  - `README.md` with quick start and command documentation.
  - `docs/architecture.md`: Comprehensive system architecture and technology choices report.
  - `docs/implementation-plan.md`: Phase-by-phase delivery breakdown.
  - `docs/components.md`: Complete component API reference.
  - `docs/authentication.md`: Authentication flows and security hardening guide.

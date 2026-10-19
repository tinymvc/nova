<p align="center">
    <img width="1216" height="415" alt="tinymvc-spark-nova" src="https://github.com/user-attachments/assets/c167c5d0-f946-440a-b5fa-012a63cd7910" />
</p>

# Nova — TinyMVC / Spark Starter Kit

**Nova** is a modern, production-conscious starter kit for the **TinyMVC / Spark** PHP framework. It provides developers with a robust foundation for building high-performance, server-rendered web applications with interactive client-side behaviors, pre-built accessible UI components, and complete security-hardened authentication.

---

## Tech Stack

- **Backend**: [TinyMVC / Spark](https://github.com/tinymvc/tinycore) (`tinymvc/tinycore`) v4.0
- **Templates**: Spark Blade Template Engine
- **Styling**: [Tailwind CSS 4](https://tailwindcss.com) + [daisyUI 5](https://daisyui.com)
- **Client Interactivity**: [Alpine.js 3](https://alpinejs.dev)
- **SPA-like Transitions**: [FireLine 2.1](https://github.com/tinymvc/fireline-php) (`@tinymvc/fireline-php` & `fireline` npm)
- **Asset Bundling**: [Vite 7](https://vitejs.dev)

---

## Features

- **25+ Reusable Blade Components**: Buttons, badges, form inputs with password visibility toggle, cards, modals, confirmation dialogs, dropdowns, alerts, breadcrumbs, tables, pagination, and skeletons.
- **Complete Authentication Flows**:
  - Secure sign-in with login rate limiting (`throttle:10,1`).
  - Session fixation defense (`session()->regenerate()`) and session invalidation at logout.
  - User registration with unique username/email validation.
  - Expiring (60 min), single-use password reset links dispatched via email.
  - Safe generic responses to prevent user enumeration.
  - Argon2id / Bcrypt password hashing.
- **Responsive Admin Dashboard**:
  - Key metric statistic cards with trend tokens.
  - Demonstration records table with status badges.
  - Activity stream and interactive project modal.
  - Accessible mobile drawer and collapsible sidebar.
- **User Profile Management**:
  - Name, username, and email updates.
  - Secure password changes requiring current password verification.
- **FireLine SPA Navigation**:
  - Instant page transitions with `x-navigate` on links without full-page reloads.
- **Automated Testing**:
  - Comprehensive suite of 33 feature and unit tests with 93 assertions covering authentication, authorization, registration, password resets, profile management, and component rendering.

---

## Quick Start & Installation

### 1. Requirements
- PHP 8.2 or higher (with `pdo_sqlite` or MySQL, `curl`, `fileinfo`)
- Composer
- Node.js 18+ and npm

### 2. Clone and Setup
```bash
# Clone the repository
git clone https://github.com/tinymvc/skeleton.git nova-app
cd nova-app

# Run automatic setup (installs Composer packages, copies .env, generates APP_KEY, runs migrations, and builds assets)
composer setup
```

Or execute the steps manually:
```bash
# 1. Install PHP dependencies
composer install

# 2. Environment configuration
cp .env.example .env
php spark key:generate

# 3. Database migrations
php spark migrate --seed

# 4. Frontend assets
npm install
npm run build
```

### 3. Start Development Servers
Run the Spark development server:
```bash
php spark serve
```
*(Runs by default at `http://localhost:8080`)*

In a separate terminal, start the Vite development server for hot-reloading:
```bash
npm run dev
```

---

## Running Tests

Run the complete automated test suite using the Spark test runner:
```bash
php test
```
Or via composer:
```bash
composer test
```

---

## Architecture & Documentation

Nova includes in-depth guides covering design decisions, components, and security mechanisms:

- **[Component Reference](docs/components.md)**: Props, variants, and usage examples for all 25+ Blade components.
- **[Authentication Guide](docs/authentication.md)**: Complete security architecture, session handling, and reset token lifecycles.
- **[Architecture & Design Decisions](docs/architecture.md)**: Framework taxonomy, technology choices, and FireLine integration details.
- **[Implementation Plan](docs/implementation-plan.md)**: Phase-by-phase delivery breakdown and verification report.

---

## Available Commands

| Command | Description |
| --- | --- |
| `php spark serve` | Starts the local PHP development server |
| `php spark migrate` | Runs pending database migrations |
| `php spark migrate:rollback` | Rolls back the latest database migration |
| `php spark key:generate` | Generates a cryptographically secure 32-character `APP_KEY` |
| `php test` | Executes the test suite |
| `npm run dev` | Runs the Vite development server |
| `npm run build` | Builds optimized production assets |

---

## Contributing

Contributions are welcome! Please submit pull requests or report issues to the repository.

## License

The Nova starter kit is open-source software licensed under the [MIT License](LICENSE).

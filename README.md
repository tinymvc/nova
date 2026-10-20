# Nova

A clean, minimal starter kit for **TinyMVC / Spark**, built with **Blade, Alpine.js, FireLine, Tailwind CSS 4, and daisyUI 5**.

Nova is the starter package name. The included interface uses **Spark by TinyMVC** branding.

## Features

- **Authentication** — registration, sign-in, remember me, logout, and password recovery.
- **Account settings** — update profile details and change passwords.
- **Projects workspace** — create, edit, delete, search, paginate, and track project status. Each account has its own projects.
- **Responsive interface** — homepage, authentication screens, dashboard, and account settings with mobile navigation.
- **Interactive forms** — inline validation, loading indicators, password visibility, and success notices.
- **Smooth navigation** — FireLine page transitions with browser history support.
- **Automated tests** — authentication, account settings, projects, validation, and access protection.

## UI components

Reusable Blade components are included in `resources/views/components`.

| Category | Components |
| --- | --- |
| Layout | Guest, authentication, and app layouts; branding, page headers, breadcrumbs, dividers |
| Forms | Forms, inputs, textareas, selects, checkboxes, radios, toggles, labels, help text, errors, submit buttons |
| Display | Buttons, links, cards, tables, badges, avatars, icons, pagination |
| Feedback | Alerts, flash notices, empty states, loading indicators, skeletons |
| Interaction | Modals, confirmation dialogs, dropdowns, tooltips |

## Getting started

Requires PHP 8.2+, Composer, PDO SQLite (or MySQL), and Node.js 20.19+ or 22.12+.

```sh
composer create-project tinymvc/nova tinyapp
cd tinyapp
npm install
npm run build
php spark serve
```

Composer installs PHP dependencies, creates `.env`, generates the application key, and runs database migrations and seeders. The npm commands install and build the frontend assets. Open [localhost:8080](http://localhost:8080) and create an account.

For a fresh source checkout, run `composer setup` to install dependencies, prepare the application, and build assets, then run `php spark serve`.

Application, database, and email settings are configured in `.env`. Password reset emails are logged to `storage/logs` by default. For email delivery, set `MAIL_TRANSPORT=smtp` and configure the `MAIL_*` settings.

## Commands

```sh
npm run dev          # Asset hot reload
npm run build        # Production assets
php spark migrate    # Database migrations
php test             # Run tests
```

## License

Nova is open source under the [MIT License](LICENSE).

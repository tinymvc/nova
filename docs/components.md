# Nova Blade Components Guide

Nova provides a comprehensive suite of accessible, DaisyUI 5-backed, Tailwind CSS 4-styled Blade components. They are designed for developer productivity, consistent UX, and clean HTML output.

All components reside in `resources/views/components/` and are invoked using standard Blade `<x-component-name>` syntax.

---

## 1. Action & Navigation Components

### Button (`<x-button>`)
Standard clickable button with variants, sizes, loading states, and icon support.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `type` | `string` | `'button'` | Button type: `button`, `submit`, `reset` |
| `variant` | `string` | `'primary'` | `primary`, `secondary`, `accent`, `neutral`, `ghost`, `link`, `outline`, `error`, `success`, `warning`, `info` |
| `size` | `string` | `'md'` | `xs`, `sm`, `md`, `lg`, `xl` |
| `icon` | `string|null` | `null` | Heroicon name to display before button text |
| `loading` | `bool` | `false` | Displays a loading spinner and disables button |
| `disabled` | `bool` | `false` | Disables the button |

**Usage:**
```blade
<x-button variant="primary" size="md">Save Changes</x-button>
<x-button type="submit" variant="success" icon="check">Submit Form</x-button>
<x-button variant="ghost" size="sm" icon="trash">Delete</x-button>
```

---

### Link (`<x-link>`)
Semantic `<a>` tag with styling variants and optional SPA navigation (`x-navigate`).

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `href` | `string` | `'#'` | Target URL |
| `variant` | `string` | `'primary'` | `primary`, `secondary`, `accent`, `neutral`, `hover`, `muted` |
| `underline` | `bool` | `false` | Always underlines link text |
| `external` | `bool` | `false` | Adds `target="_blank"` and `rel="noopener noreferrer"` |

**Usage:**
```blade
<x-link href="/dashboard">Back to Dashboard</x-link>
<x-link href="https://example.com" external variant="muted">External Documentation</x-link>
```

---

### Icon (`<x-icon>`)
Embeds clean, accessible inline SVG Heroicons (v2 Outline/Solid).

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Icon name (e.g., `user`, `lock`, `mail`, `dashboard`, `trash`, `plus`, etc.) |
| `size` | `string` | `'md'` | `xs` (12px), `sm` (16px), `md` (20px), `lg` (24px), `xl` (32px) |

**Usage:**
```blade
<x-icon name="dashboard" size="sm" class="text-primary" />
<x-icon name="check-circle" size="md" class="text-success" />
```

---

### Divider (`<x-divider>`)
Visual separator with optional centered label.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `label` | `string|null` | `null` | Centered text inside the divider |
| `vertical` | `bool` | `false` | Renders a vertical separator (inside flex containers) |

**Usage:**
```blade
<x-divider />
<x-divider label="OR" />
```

---

### Breadcrumb (`<x-breadcrumb>`)
Accessible hierarchy trail navigation.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `items` | `array` | `[]` | List of items: `[['label' => '...', 'url' => '...', 'icon' => '...']]` |

**Usage:**
```blade
<x-breadcrumb :items="[
    ['label' => 'Dashboard', 'url' => route('dashboard'), 'icon' => 'dashboard'],
    ['label' => 'Profile Settings'],
]" />
```

---

### Page Header (`<x-page-header>`)
Top-of-page header block with title, description, and action button slot.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `title` | `string` | required | Page heading text |
| `description` | `string|null` | `null` | Secondary explanatory text |

**Usage:**
```blade
<x-page-header title="Orders" description="View and manage customer orders.">
    <x-button variant="primary" size="sm" icon="plus">Create Order</x-button>
</x-page-header>
```

---

## 2. Form & Input Components

### Input (`<x-input>`)
Accessible input component supporting floating labels, input icons, password show/hide toggle, help text, and automatic server-side validation error rendering.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name attribute |
| `label` | `string|null` | `null` | Label text |
| `type` | `string` | `'text'` | Input type (`text`, `email`, `password`, `number`, etc.) |
| `value` | `mixed` | `null` | Default or bound value (falls back to `old($name)`) |
| `placeholder` | `string|null` | `null` | Input placeholder |
| `icon` | `string|null` | `null` | Left-side icon |
| `help` | `string|null` | `null` | Contextual help text below input |
| `required` | `bool` | `false` | Displays required indicator and HTML validation |
| `readonly` | `bool` | `false` | Sets readonly attribute |
| `disabled` | `bool` | `false` | Sets disabled attribute |

**Usage:**
```blade
<x-input
    name="email"
    type="email"
    label="Email Address"
    placeholder="you@domain.com"
    icon="mail"
    required
/>

{{-- Password with built-in Alpine.js show/hide toggle --}}
<x-input
    name="password"
    type="password"
    label="Password"
    placeholder="••••••••"
    icon="lock"
    required
/>
```

---

### Textarea (`<x-textarea>`)
Multiline text area with label, character counter support, and validation errors.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name |
| `label` | `string|null` | `null` | Field label |
| `rows` | `int` | `3` | Number of visible rows |
| `value` | `string|null` | `null` | Initial text value |

**Usage:**
```blade
<x-textarea name="bio" label="About You" placeholder="Write a short summary..." rows="4" />
```

---

### Select (`<x-select>`)
Native dropdown select menu.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name |
| `label` | `string|null` | `null` | Field label |
| `options` | `array` | `[]` | Key-value array or indexed options |
| `selected` | `mixed` | `null` | Selected value |
| `placeholder` | `string|null` | `null` | Default unselected prompt option |

**Usage:**
```blade
<x-select
    name="role"
    label="User Role"
    :options="['admin' => 'Administrator', 'editor' => 'Editor', 'viewer' => 'Viewer']"
    selected="editor"
/>
```

---

### Checkbox (`<x-checkbox>`)
DaisyUI checkbox control with integrated label and validation error.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name |
| `label` | `string` | required | Text label beside the checkbox |
| `checked` | `bool` | `false` | Checked state |

**Usage:**
```blade
<x-checkbox name="remember" label="Remember me on this device" />
```

---

### Toggle (`<x-toggle>`)
Modern switch toggle control.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name |
| `label` | `string` | required | Toggle label |
| `checked` | `bool` | `false` | Active state |

**Usage:**
```blade
<x-toggle name="notifications" label="Enable push notifications" checked />
```

---

## 3. Feedback & Data Display

### Card (`<x-card>`)
DaisyUI card container with title, subtitle, and body slot.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `title` | `string|null` | `null` | Card heading |
| `subtitle` | `string|null` | `null` | Subtitle description |
| `bordered` | `bool` | `true` | Renders border around the card |
| `shadow` | `string` | `'sm'` | `none`, `sm`, `md`, `lg`, `xl` |

**Usage:**
```blade
<x-card title="System Health" subtitle="Real-time monitoring metrics">
    <p class="text-sm">All services operating normally.</p>
</x-card>
```

---

### Badge (`<x-badge>`)
Pill badge for statuses, labels, and counts.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `variant` | `string` | `'neutral'` | `primary`, `secondary`, `accent`, `neutral`, `info`, `success`, `warning`, `error` |
| `size` | `string` | `'sm'` | `xs`, `sm`, `md`, `lg` |
| `outline` | `bool` | `false` | Renders outline style |

**Usage:**
```blade
<x-badge variant="success" size="xs">Active</x-badge>
<x-badge variant="warning" outline>Pending Review</x-badge>
```

---

### Avatar (`<x-avatar>`)
User profile avatar with automatic initial generation when no image is supplied.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `src` | `string|null` | `null` | Image URL |
| `name` | `string|null` | `null` | Used for calculating initials (e.g. `'John Doe'` -> `'JD'`) |
| `size` | `string` | `'md'` | `xs`, `sm`, `md`, `lg`, `xl` |
| `shape` | `string` | `'circle'` | `circle`, `squircle`, `rounded`, `square` |
| `status` | `string|null` | `null` | `online`, `offline` status dot |

**Usage:**
```blade
<x-avatar :name="user('name')" size="sm" status="online" />
<x-avatar src="/avatars/user.jpg" size="md" shape="squircle" />
```

---

### Alert (`<x-alert>`)
Informational or feedback notification container.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `type` | `string` | `'info'` | `info`, `success`, `warning`, `error` |
| `title` | `string|null` | `null` | Optional alert heading |
| `dismissible` | `bool` | `false` | Enables client-side dismissal button |

**Usage:**
```blade
<x-alert type="success" title="Success!">Your settings have been saved.</x-alert>
<x-alert type="error" title="Error">Failed to process payment.</x-alert>
```

---

### Flash (`<x-flash>`)
Automatically renders flash session alerts (`status`, `success`, `error`, `warning`, `info`).

**Usage:**
```blade
<x-flash />
```

---

## 4. Overlay & Interactive Components

### Modal (`<x-modal>`)
Accessible native `<dialog>` modal powered by DaisyUI and Alpine.js.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `id` | `string` | required | Unique DOM identifier |
| `title` | `string|null` | `null` | Modal header title |
| `maxWidth` | `string` | `'md'` | `sm`, `md`, `lg`, `xl`, `2xl`, `full` |

**Usage:**
```blade
<x-button onclick="document.getElementById('demo-modal').showModal()">
    Open Modal
</x-button>

<x-modal id="demo-modal" title="Confirm Action">
    <p class="text-sm">Are you sure you want to proceed?</p>
    <div class="modal-action">
        <form method="dialog">
            <x-button type="submit" variant="ghost" size="sm">Cancel</x-button>
        </form>
    </div>
</x-modal>
```

---

### Confirmation Dialog (`<x-confirm-dialog>`)
Specialized modal designed for destructive or important confirmations with action form integration.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `id` | `string` | required | Modal ID |
| `title` | `string` | `'Confirm Action'` | Heading |
| `message` | `string` | required | Confirmation message |
| `confirmText` | `string` | `'Confirm'` | Confirm button text |
| `confirmVariant` | `string` | `'error'` | Confirm button variant |
| `action` | `string` | required | Target POST/DELETE URL |
| `method` | `string` | `'POST'` | HTTP method (`POST`, `DELETE`, `PUT`) |

---

### Dropdown (`<x-dropdown>`)
DaisyUI accessible dropdown menu.

**Props:**
| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `align` | `string` | `'end'` | `start`, `end`, `top`, `bottom`, `left`, `right` |
| `width` | `string` | `'w-52'` | Tailwind width class |

---

## 5. Layouts & Structure

Nova offers three standard layouts located in `resources/views/layouts/`:

1. **`layouts.app`**: Authenticated dashboard layout with sidebar navigation, user dropdown, mobile drawer, Fireline root container, and breadcrumb support.
2. **`layouts.auth`**: Centered card layout for authentication flows (login, register, forgot-password, reset-password).
3. **`layouts.guest`**: Public marketing layout with top navbar, brand logo, and responsive footer.

### Layout Implementation Example:
```blade
@extends('layouts.app')
@section('title', 'My Custom Page')

@section('content')
    <x-page-header title="My Page" description="Detailed page description." />

    <div class="space-y-6">
        {{-- Your page content --}}
    </div>
@endsection
```

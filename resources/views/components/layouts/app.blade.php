@props([
    'title' => 'Dashboard',
])
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ config('app.name', 'Nova') }}</title>
    @vite('app.js')
</head>
<body
    class="min-h-screen bg-base-200/50 text-base-content font-sans antialiased selection:bg-primary selection:text-primary-content"
    x-data="{ mobileNavOpen: false }"
>

    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- Mobile Backdrop --}}
        <div
            x-show="mobileNavOpen"
            x-transition.opacity
            @click="mobileNavOpen = false"
            class="fixed inset-0 bg-neutral/40 z-40 lg:hidden"
            style="display: none;"
            aria-hidden="true"
        ></div>

        {{-- Sidebar (Desktop + Mobile off-canvas) --}}
        <aside
            :class="mobileNavOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:sticky top-0 left-0 z-50 h-screen w-64 bg-base-100 border-r border-base-200 flex flex-col justify-between transition-transform duration-200 ease-in-out shrink-0"
        >
            {{-- Sidebar Header --}}
            <div>
                <div class="h-16 flex items-center justify-between px-6 border-b border-base-200">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 font-bold text-xl tracking-tight text-base-content hover:opacity-90" x-navigate>
                        <div class="w-8 h-8 rounded-lg bg-primary text-primary-content flex items-center justify-center font-black shadow-md shadow-primary/25">
                            N
                        </div>
                        <span>Nova</span>
                        <span class="badge badge-primary badge-xs">v1.0</span>
                    </a>

                    <button
                        type="button"
                        class="btn btn-ghost btn-xs btn-square lg:hidden"
                        @click="mobileNavOpen = false"
                        aria-label="Close sidebar"
                    >
                        <x-icon name="x-mark" size="sm" />
                    </button>
                </div>

                {{-- Navigation Links --}}
                <nav class="p-4 space-y-1">
                    <div class="text-[11px] font-bold text-base-content/40 uppercase tracking-wider px-3 mb-2">Main Menu</div>

                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->is('dashboard*') ? 'bg-primary text-primary-content shadow-sm shadow-primary/20' : 'text-base-content/80 hover:bg-base-200 hover:text-base-content' }}"
                        x-navigate
                    >
                        <x-icon name="dashboard" size="sm" />
                        <span>Dashboard</span>
                    </a>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->is('profile*') ? 'bg-primary text-primary-content shadow-sm shadow-primary/20' : 'text-base-content/80 hover:bg-base-200 hover:text-base-content' }}"
                        x-navigate
                    >
                        <x-icon name="user" size="sm" />
                        <span>My Profile</span>
                    </a>

                    <a
                        href="/"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-base-content/80 hover:bg-base-200 hover:text-base-content transition-colors"
                        x-navigate
                    >
                        <x-icon name="search" size="sm" />
                        <span>Landing Page</span>
                    </a>
                </nav>
            </div>

            {{-- Sidebar Footer / User Profile summary --}}
            <div class="p-4 border-t border-base-200 bg-base-200/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <x-avatar :name="user('name')" size="sm" />
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-base-content truncate">{{ user('name') }}</p>
                            <p class="text-[11px] text-base-content/60 truncate">{{ user('email') }}</p>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-xs btn-square text-error hover:bg-error/10" title="Sign out">
                            <x-icon name="logout" size="xs" />
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Layout Right Container --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top Header --}}
            <header class="h-16 bg-base-100 border-b border-base-200 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 backdrop-blur-md bg-base-100/90">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="btn btn-ghost btn-sm btn-square lg:hidden"
                        @click="mobileNavOpen = true"
                        aria-label="Open sidebar"
                    >
                        <x-icon name="menu" size="md" />
                    </button>

                    <h2 class="text-lg font-bold text-base-content hidden sm:block">{{ $title }}</h2>
                </div>

                {{-- User Actions --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Notifications demo --}}
                    <button type="button" class="btn btn-ghost btn-sm btn-circle" aria-label="Notifications" title="Notifications">
                        <x-icon name="bell" size="sm" />
                    </button>

                    {{-- User Dropdown --}}
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-sm gap-2 pl-1 pr-2 rounded-full cursor-pointer">
                            <x-avatar :name="user('name')" size="xs" />
                            <span class="text-xs font-semibold hidden md:inline">{{ user('name') }}</span>
                            <x-icon name="chevron-down" size="xs" class="opacity-60" />
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-56 border border-base-200 mt-2 z-50 text-xs">
                            <li class="menu-title px-3 py-2 border-b border-base-200 mb-1">
                                <span class="font-bold text-base-content block">{{ user('name') }}</span>
                                <span class="font-normal text-base-content/60 truncate block">{{ user('email') }}</span>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit') }}" class="py-2" x-navigate>
                                    <x-icon name="user" size="xs" />
                                    <span>Profile Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard') }}" class="py-2" x-navigate>
                                    <x-icon name="dashboard" size="xs" />
                                    <span>Dashboard Overview</span>
                                </a>
                            </li>
                            <li class="border-t border-base-200 mt-1 pt-1">
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left py-2 text-error hover:bg-error/10 rounded-md flex items-center gap-2">
                                        <x-icon name="logout" size="xs" />
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            {{-- Main Body Content for FireLine (#app > div) --}}
            <main id="app" class="flex-1">
                <div>
                    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
                        <x-flash />
                        {{ $slot }}
                    </div>
                </div>
            </main>

            {{-- Footer --}}
            <footer class="p-4 text-center text-xs text-base-content/40 border-t border-base-200">
                Nova Starter Kit &copy; {{ now()->year }} &middot; Powered by TinyMVC / Spark
            </footer>

        </div>

    </div>

</body>
</html>

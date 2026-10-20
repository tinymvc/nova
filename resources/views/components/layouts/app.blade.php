@props(['title' => 'Overview', 'active' => 'dashboard'])
<div class="min-h-svh bg-base-200 lg:pl-60 flex flex-col" x-data="{ mobileNavOpen: false, desktop: window.innerWidth >= 1024 }"
    @resize.window.debounce.100ms="desktop = window.innerWidth >= 1024; if (desktop) mobileNavOpen = false"
    @keydown.escape.window="if (mobileNavOpen) { mobileNavOpen = false; $refs.mobileMenu.focus() }"
    :data-mobile-open="mobileNavOpen && !desktop" {{ $attributes }}>
    <button x-cloak x-show="mobileNavOpen" @click="mobileNavOpen = false; $refs.mobileMenu.focus()"
        class="fixed inset-0 z-40 bg-neutral/30 backdrop-blur-sm lg:hidden" aria-label="Close navigation"></button>
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-60 z-50 bg-base-200 border-r border-base-300 flex flex-col transition-transform duration-200 lg:translate-x-0"
        :class="mobileNavOpen ? 'translate-x-0' : '-translate-x-full'" :inert="!mobileNavOpen && !desktop">
        <div class="h-20 px-6 flex items-center justify-between shrink-0">
            <x-brand :href="route('dashboard')" />
            <button class="btn btn-ghost btn-square btn-sm lg:hidden"
                @click="mobileNavOpen = false; $refs.mobileMenu.focus()" aria-label="Close navigation"><x-icon name="x-mark" /></button>
        </div>
        <nav class="px-3 pt-3 space-y-1" aria-label="Main navigation">
            <a href="{{ route('dashboard') }}" x-navigate class="nav-link {{ $active === 'dashboard' ? 'is-active' : '' }}"
                @if ($active === 'dashboard') aria-current="page" @endif>
                <x-icon name="dashboard" size="sm" /> Overview
            </a>
            <a href="{{ route('profile.edit') }}" x-navigate class="nav-link {{ $active === 'profile' ? 'is-active' : '' }}"
                @if ($active === 'profile') aria-current="page" @endif>
                <x-icon name="user" size="sm" /> Account settings
            </a>
        </nav>
        <div class="mt-auto pt-8">
            <nav class="px-3 pb-4 space-y-1" aria-label="Resources">
                <a href="https://tinymvc.github.io" target="_blank" rel="noopener noreferrer" class="nav-link">
                    <x-icon name="book-open" size="sm" /> Explore Spark <x-icon name="arrow-up-right" size="xs" class="ml-auto" />
                </a>
                <a href="{{ route('home') }}" x-navigate class="nav-link">
                    <x-icon name="flame" size="sm" /> Spark homepage <x-icon name="arrow-up-right" size="xs" class="ml-auto" />
                </a>
            </nav>
            <div class="border-t border-base-300 p-4 flex items-center gap-2.5">
                <x-avatar :name="user('name')" size="sm" shape="rounded" />
                <a href="{{ route('profile.edit') }}" x-navigate class="min-w-0 flex-1 rounded focus-visible:outline-offset-4">
                    <p class="text-xs font-medium truncate">{{ user('name') }}</p>
                    <p class="text-[11px] muted truncate">{{ user('email') }}</p>
                </a>
                <form method="post" action="{{ route('logout') }}" x-data="{ form: $form() }" x-form>
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-square btn-sm muted" :disabled="form.processing"
                        aria-label="Sign out" title="Sign out"><x-icon name="logout" size="sm" /></button>
                </form>
            </div>
        </div>
    </aside>
    <header :inert="mobileNavOpen && !desktop" class="h-16 border-b border-base-300 flex items-center px-5 sm:px-8 shrink-0 lg:hidden">
        <div class="flex items-center gap-3">
            <button x-ref="mobileMenu" class="btn btn-ghost btn-square btn-sm lg:hidden"
                @click="mobileNavOpen = true; $nextTick(() => document.querySelector('#sidebar button').focus())"
                :aria-expanded="mobileNavOpen" aria-controls="sidebar" aria-label="Open navigation"><x-icon name="menu" /></button>
            <span class="text-xs font-medium">{{ $title }}</span>
        </div>
    </header>
    <main :inert="mobileNavOpen && !desktop" id="main-content" class="w-full max-w-6xl mx-auto px-5 sm:px-8 xl:px-10 py-8 lg:py-12 flex-1">
        <x-flash />
        {{ $slot }}
    </main>
</div>

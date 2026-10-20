@props(['title' => 'Overview', 'active' => 'dashboard'])
<div class="min-h-svh bg-base-200 lg:pl-60" x-data="{ mobileNavOpen: false, desktop: window.innerWidth >= 1024 }"
    @resize.window.debounce.100ms="desktop = window.innerWidth >= 1024; if (desktop) mobileNavOpen = false"
    @keydown.escape.window="if (mobileNavOpen) { mobileNavOpen = false; $refs.mobileMenu.focus() }"
    :data-mobile-open="mobileNavOpen && !desktop" {{ $attributes }}>
    <button x-cloak x-show="mobileNavOpen" @click="mobileNavOpen = false"
        class="fixed inset-0 z-40 bg-neutral/30 lg:hidden" aria-label="Close navigation"></button>
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-60 z-50 bg-[#f8f8f6] border-r border-base-300 flex flex-col transition-transform lg:translate-x-0"
        :class="mobileNavOpen ? 'translate-x-0' : '-translate-x-full'" :inert="!mobileNavOpen && !desktop">
        <div class="h-20 px-6 flex items-center justify-between">
            <x-brand :href="route('dashboard')" />
            <button class="btn btn-ghost btn-square btn-sm lg:hidden"
                @click="mobileNavOpen = false; $refs.mobileMenu.focus()" aria-label="Close navigation"><x-icon
                    name="x-mark" /></button>
        </div>
        <div class="mx-4 mb-7 px-3 py-3 border border-base-300 rounded-lg flex items-center gap-3 bg-white">
            <span class="grid place-items-center w-8 h-8 bg-base-200 border border-base-300 rounded-md"><x-icon
                    name="dashboard" size="sm" /></span>
            <div>
                <p class="text-xs font-medium">Personal workspace</p>
                <p class="text-[11px] muted mt-0.5">Your corner of Nova</p>
            </div>
        </div>
        <nav class="px-4 space-y-1" aria-label="Workspace">
            <p class="eyebrow px-3 mb-3">Workspace</p>
            <a href="{{ route('dashboard') }}" x-navigate
                class="nav-link {{ $active === 'dashboard' ? 'is-active' : '' }}"
                @if ($active === 'dashboard') aria-current="page" @endif><x-icon name="dashboard"
                    size="sm" />Overview</a>
            <a href="{{ route('profile.edit') }}" x-navigate
                class="nav-link {{ $active === 'profile' ? 'is-active' : '' }}"
                @if ($active === 'profile') aria-current="page" @endif><x-icon name="user"
                    size="sm" />Account settings</a>
        </nav>
        <div class="mt-auto px-4 pb-5">
            <div class="rounded-lg border border-base-300 p-4 mb-6 bg-white/60">
                <span class="text-primary"><x-icon name="code" size="md" /></span>
                <p class="text-xs font-medium mt-3">Make it your own.</p>
                <p class="text-[11px] muted mt-1 leading-5">Small beginnings. Endless possibilities.</p>
                <a href="https://github.com/tinymvc/tinycore" target="_blank" rel="noopener noreferrer"
                    class="text-[11px] text-primary inline-flex items-center gap-2 mt-3">Explore Spark <x-icon
                        name="arrow-right" size="xs" /></a>
            </div>
            <div class="border-t border-base-300 pt-4 flex items-center gap-3 px-1">
                <x-avatar :name="user('name')" size="sm" />
                <a href="{{ route('profile.edit') }}" x-navigate class="min-w-0 flex-1">
                    <p class="text-xs font-medium truncate">{{ user('name') }}</p>
                    <p class="text-[11px] muted truncate mt-0.5">{{ user('email') }}</p>
                </a>
                <form method="post" action="{{ route('logout') }}" x-data="{ form: $form() }" x-form>
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-square btn-sm muted" :disabled="form.processing"
                        aria-label="Sign out" title="Sign out"><x-icon name="logout" size="sm" /></button>
                </form>
            </div>
        </div>
    </aside>
    <header :inert="mobileNavOpen && !desktop"
        class="h-20 border-b border-base-300 bg-white/80 flex items-center justify-between px-6 lg:px-10">
        <div class="flex items-center gap-3">
            <button x-ref="mobileMenu" class="btn btn-ghost btn-square btn-sm lg:hidden"
                @click="mobileNavOpen = true; $nextTick(() => document.querySelector('#sidebar button').focus())"
                :aria-expanded="mobileNavOpen" aria-controls="sidebar" aria-label="Open navigation"><x-icon
                    name="menu" /></button>
            <span class="text-xs muted hidden sm:inline">Workspace</span><span
                class="text-base-300 hidden sm:inline">/</span><span
                class="text-xs font-medium">{{ $title }}</span>
        </div>
        <a href="{{ route('home') }}" x-navigate
            class="inline-flex items-center gap-2 text-xs muted hover:text-base-content">Visit homepage <x-icon
                name="arrow-right" size="xs" /></a>
    </header>
    <main :inert="mobileNavOpen && !desktop" id="main-content"
        class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-8 lg:py-10">
        <x-flash />
        {{ $slot }}
    </main>
    <footer :inert="mobileNavOpen && !desktop"
        class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 py-7 flex justify-between text-[11px] muted"><span>Nova starter
            kit</span><span>Built with TinyMVC / Spark <span class="text-primary ml-1">✳</span></span></footer>
</div>

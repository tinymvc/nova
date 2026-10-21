<x-fire title="Welcome · {{ config('app.name', 'Spark') }}">
    <x-layouts.guest key="home">
        <section class="w-full max-w-md text-center">
            <h1 data-page-heading tabindex="-1">
                <x-brand :stacked="true" />
            </h1>
            <p class="muted text-[15px] leading-7 mt-7">A lightweight MVC framework for PHP artisans.<br>Simple tools,
                clean code, real projects.</p>
            <p class="text-xs muted mt-3">Blade <span class="mx-1.5 text-base-content/25">·</span> Alpine.js <span
                    class="mx-1.5 text-base-content/25">·</span> FireLine <span
                    class="mx-1.5 text-base-content/25">·</span> daisyUI</p>
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                <a href="https://tinymvc.github.io" class="btn btn-primary px-5" target="_blank"
                    rel="noopener noreferrer">
                    Documentation <x-icon name="arrow-up-right" size="sm" />
                </a>
                <a href="https://github.com/tinymvc/tinycore/tree/main/src" class="btn btn-outline px-5" target="_blank"
                    rel="noopener noreferrer">
                    GitHub <x-icon name="arrow-up-right" size="sm" />
                </a>
            </div>
            <nav aria-label="Community resources" class="flex justify-center gap-6 mt-8 text-xs muted">
                <a href="https://github.com/tinymvc/tinycore/stargazers" class="hover:text-base-content" target="_blank"
                    rel="noopener noreferrer">Star</a>
                <a href="https://github.com/tinymvc/tinycore/issues" class="hover:text-base-content" target="_blank"
                    rel="noopener noreferrer">Issues</a>
                <a href="https://github.com/tinymvc/tinycore/releases" class="hover:text-base-content" target="_blank"
                    rel="noopener noreferrer">Releases</a>
            </nav>
        </section>
    </x-layouts.guest>
</x-fire>

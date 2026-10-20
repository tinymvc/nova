@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    A fresh start · {{ config('app.name', 'Nova') }}
@endsection

@section('content')
    <x-layouts.guest key="home">
        <section
            class="max-w-6xl mx-auto px-6 lg:px-8 pt-16 pb-20 lg:pt-24 lg:pb-28 grid lg:grid-cols-[1.05fr_1fr] gap-14 lg:gap-20 items-center">
            <div>
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-base-300 px-3 py-1.5 text-[11px] muted mb-8">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>The TinyMVC / Spark starter kit</div>
                <h1 data-page-heading tabindex="-1"
                    class="text-[3.5rem] sm:text-7xl lg:text-[5.2rem] leading-[1.04] tracking-[-0.065em] font-medium">Less
                    setup.<br>More <span class="text-primary">spark.</span></h1>
                <p class="muted text-base leading-7 max-w-sm mt-7">Meet Nova. A thoughtful foundation for your next web app,
                    with the essentials in place and room for everything you imagine.</p>
                <div class="flex flex-wrap gap-3 mt-9">
                    @auth
                        <a href="{{ route('dashboard') }}" x-navigate class="btn btn-primary px-5">Open your workspace <x-icon
                                name="arrow-right" size="sm" /></a>
                    @else
                        <a href="{{ route('register') }}" x-navigate class="btn btn-primary px-5">Start building <x-icon
                                name="arrow-right" size="sm" /></a>
                        <a href="{{ route('login') }}" x-navigate class="btn btn-outline px-5">Sign in</a>
                    @endauth
                </div>
                <p class="text-[11px] muted mt-5">Open source. Beautifully simple. Ready for your ideas.</p>
            </div>
            <div class="relative py-4 lg:py-10">
                <div class="absolute -inset-5 bg-[#eeedf8] rounded-full blur-3xl opacity-60 pointer-events-none"
                    aria-hidden="true"></div>
                <div class="relative panel shadow-xl shadow-[#26233a08] overflow-hidden -rotate-1">
                    <div class="flex items-center justify-between border-b border-base-300 px-5 h-12 bg-[#fafaf9]">
                        <div class="flex gap-1.5" aria-hidden="true"><span
                                class="w-2 h-2 rounded-full bg-[#d9d9d5]"></span><span
                                class="w-2 h-2 rounded-full bg-[#d9d9d5]"></span><span
                                class="w-2 h-2 rounded-full bg-[#d9d9d5]"></span></div>
                        <span class="font-mono text-[10px] muted">a fresh perspective</span><span class="w-6"></span>
                    </div>
                    <div class="p-7 sm:p-9">
                        <div class="flex items-center gap-3"><span
                                class="grid place-items-center w-10 h-10 rounded-xl bg-secondary text-primary"><x-icon
                                    name="check" /></span>
                            <div>
                                <p class="text-sm font-medium">Your next chapter</p>
                                <p class="text-[11px] muted mt-1">A great place to begin.</p>
                            </div><span class="ml-auto badge badge-success text-[10px]">Ready</span>
                        </div>
                        <div class="mt-8 space-y-4">
                            <div class="flex items-center gap-3 text-xs"><x-icon name="check" size="sm"
                                    class="text-primary" /><span>Authentication, sorted.</span><span
                                    class="ml-auto text-[10px] muted">01</span></div>
                            <div class="border-t border-base-200"></div>
                            <div class="flex items-center gap-3 text-xs"><x-icon name="check" size="sm"
                                    class="text-primary" /><span>A clean, considered interface.</span><span
                                    class="ml-auto text-[10px] muted">02</span></div>
                            <div class="border-t border-base-200"></div>
                            <div class="flex items-center gap-3 text-xs"><x-icon name="check" size="sm"
                                    class="text-primary" /><span>Space to make something yours.</span><span
                                    class="ml-auto text-[10px] muted">03</span></div>
                        </div>
                        <div
                            class="mt-8 rounded-lg bg-[#f7f7fa] border border-[#eae9f1] p-4 font-mono text-[11px] leading-6">
                            <span class="muted">// small code. big possibilities.</span><br><span
                                class="text-primary">return</span> fire(<span
                                class="text-[#5f806b]">'your.next.idea'</span>);</div>
                    </div>
                </div>
                <div
                    class="relative ml-auto -mt-3 mr-5 w-fit flex gap-2 items-center bg-white border border-base-300 rounded-lg px-4 py-3 text-[11px] shadow-sm">
                    <span class="w-1.5 h-1.5 bg-[#729d80] rounded-full"></span>Good things are taking shape.</div>
            </div>
        </section>
        <section class="border-y border-base-300 bg-[#fafaf9]">
            <div class="max-w-6xl mx-auto px-6 lg:px-8 py-7 flex flex-wrap items-center gap-x-8 gap-y-4 justify-between">
                <p class="eyebrow">A familiar stack.<br class="hidden sm:block"> A lighter starting point.</p>
                <div class="flex flex-wrap gap-x-7 gap-y-3 text-sm font-medium"><span>Blade<span
                            class="text-primary ml-1">.</span></span><span>Alpine.js<span
                            class="text-primary ml-1">.</span></span><span>FireLine<span
                            class="text-primary ml-1">.</span></span><span>daisyUI<span
                            class="text-primary ml-1">.</span></span></div>
            </div>
        </section>
        <section class="max-w-6xl mx-auto px-6 lg:px-8 py-16 lg:py-20">
            <p class="eyebrow mb-4">The essentials, thoughtfully done</p>
            <h2 class="text-3xl tracking-[-0.04em]">A head start. Without the baggage.</h2>
            <div class="grid md:grid-cols-3 gap-9 mt-11">
                <article><span class="text-primary"><x-icon name="shield-check" /></span>
                    <h3 class="text-sm font-medium mt-5">Come right in.</h3>
                    <p class="muted text-sm leading-6 mt-2">Sign in, create an account, reset a password. Familiar flows
                        that feel effortless from the first click.</p>
                </article>
                <article><span class="text-primary"><x-icon name="dashboard" /></span>
                    <h3 class="text-sm font-medium mt-5">Make yourself at home.</h3>
                    <p class="muted text-sm leading-6 mt-2">A focused workspace, account settings, and reusable components.
                        A little structure to build on.</p>
                </article>
                <article><span class="text-primary"><x-icon name="code" /></span>
                    <h3 class="text-sm font-medium mt-5">Keep your flow.</h3>
                    <p class="muted text-sm leading-6 mt-2">Server-rendered Blade with the little touches of Alpine and
                        smooth FireLine navigation. Simple feels good.</p>
                </article>
            </div>
        </section>
    </x-layouts.guest>
@endsection

@if (is_fire_js())
    @yield('content')
@endif

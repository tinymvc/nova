@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    Overview · {{ config('app.name', 'Nova') }}
@endsection

@section('content')
    <x-layouts.app key="dashboard-{{ request()->url }}-{{ $total }}">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5 mb-8">
            <div>
                <p class="eyebrow mb-3">Your personal workspace</p>
                <h1 data-page-heading tabindex="-1" class="text-3xl font-medium tracking-[-0.045em]">A fresh perspective.
                </h1>
                <p class="text-sm muted mt-3">Welcome, {{ user('name') }}. Let’s make something good.</p>
            </div>
            <button type="button" class="btn btn-primary w-fit" x-data
                @click="$dispatch('open-modal', 'create-project')"><x-icon name="plus" size="sm" />New
                project</button>
        </div>
        <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-7">
            <div class="panel p-3 sm:p-5 flex justify-between items-start">
                <div>
                    <p class="text-xs muted">Total projects</p>
                    <p class="text-2xl sm:text-3xl tracking-tight mt-3">{{ $total }}</p>
                    <p class="hidden sm:block text-[11px] muted mt-2">Ideas with a place to grow</p>
                </div><span class="hidden sm:block text-primary bg-secondary p-2 rounded-lg"><x-icon name="folder"
                        size="sm" /></span>
            </div>
            <div class="panel p-3 sm:p-5 flex justify-between items-start">
                <div>
                    <p class="text-xs muted">In progress</p>
                    <p class="text-2xl sm:text-3xl tracking-tight mt-3">{{ $inProgress }}</p>
                    <p class="hidden sm:block text-[11px] muted mt-2">Good things in the making</p>
                </div><span class="hidden sm:block text-[#a78032] bg-warning p-2 rounded-lg"><x-icon name="chart-bar"
                        size="sm" /></span>
            </div>
            <div class="panel p-3 sm:p-5 flex justify-between items-start">
                <div>
                    <p class="text-xs muted">Completed</p>
                    <p class="text-2xl sm:text-3xl tracking-tight mt-3">{{ $completed }}</p>
                    <p class="hidden sm:block text-[11px] muted mt-2">A little progress, every day</p>
                </div><span class="hidden sm:block text-success-content bg-success p-2 rounded-lg"><x-icon name="check"
                        size="sm" /></span>
            </div>
        </div>
        <div class="grid xl:grid-cols-[1fr_280px] gap-6 items-start">
            <section class="panel min-w-0" aria-labelledby="projects-heading">
                <div class="flex flex-col sm:flex-row justify-between gap-4 p-5 border-b border-base-300 sm:items-center">
                    <div class="flex items-center gap-2">
                        <h2 id="projects-heading" class="text-sm font-medium">Your projects</h2><span
                            class="text-[10px] muted border border-base-300 px-1.5 rounded">{{ $total }}</span>
                    </div>
                    <form action="{{ route('dashboard') }}" method="get" class="flex gap-2" x-data="{ form: $form() }"
                        x-form>
                        <label class="input input-sm flex items-center gap-2 w-full sm:w-44"><x-icon name="search"
                                size="xs" /><input name="q" value="{{ $search }}"
                                placeholder="Search projects…" aria-label="Search projects" maxlength="100"></label>
                        <button class="btn btn-outline btn-sm" type="submit" :disabled="form.processing">Search</button>
                    </form>
                </div>
                @if ($projects->total() > 0)
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th scope="col">Project</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="hidden md:table-cell">Created</th>
                                    <th scope="col"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects->items() as $project)
                                    <tr key="project-{{ $project->id }}" class="border-base-200">
                                        <td>
                                            <div class="flex items-center gap-3"><span
                                                    class="hidden sm:inline-block bg-secondary text-primary p-2 rounded-lg"><x-icon name="folder"
                                                        size="sm" /></span>
                                                <div class="min-w-0"><button type="button"
                                                        class="font-medium max-w-32 sm:max-w-56 truncate text-left hover:text-primary"
                                                        x-data
                                                        @click="$dispatch('open-modal', 'edit-project-{{ $project->id }}')"
                                                        aria-label="Edit {{ $project->name }}">{{ $project->name }}</button>
                                                    <p class="text-[11px] muted mt-1 max-w-32 sm:max-w-56 truncate">
                                                        {{ $project->description ?: 'A new idea, taking shape.' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge badge-sm text-[10px] whitespace-nowrap {{ $project->status === 'completed' ? 'badge-success' : ($project->status === 'in_progress' ? 'badge-warning' : 'badge-secondary') }}">{{ \App\Models\Project::STATUSES[$project->status] ?? 'Planning' }}</span>
                                        </td>
                                        <td class="hidden md:table-cell text-[11px] muted whitespace-nowrap">
                                            {{ $project->created_at->format('M j, Y') }}</td>
                                        <td><button type="button" class="btn btn-ghost btn-square btn-xs muted" x-data
                                                @click="$dispatch('open-modal', 'delete-project-{{ $project->id }}')"
                                                aria-label="Delete {{ $project->name }}"><x-icon name="trash"
                                                    size="sm" /></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-5"><x-pagination :paginator="$projects" /></div>
                @else
                    <div class="text-center px-6 py-16 sm:py-20">
                        <span
                            class="mx-auto grid place-items-center w-14 h-14 rounded-2xl bg-[#f4f3fa] border border-[#e8e5f4] text-primary mb-5"><x-icon
                                name="folder" size="lg" /></span>
                        <h3 class="text-sm font-medium">{{ $search ? 'No projects found.' : 'Big things start small.' }}
                        </h3>
                        <p class="text-xs muted mt-2 leading-6 max-w-60 mx-auto">
                            {{ $search ? 'Try a different search, or clear your filters.' : 'Give your next idea a home. Create your first project to get things moving.' }}
                        </p>
                        @if ($search)
                            <a href="{{ route('dashboard') }}" x-navigate class="btn btn-outline btn-sm mt-6">Clear
                                search</a>
                        @else
                            <button type="button" class="btn btn-outline btn-sm mt-6" x-data
                                @click="$dispatch('open-modal', 'create-project')"><x-icon name="plus"
                                    size="xs" />Create your first project</button>
                        @endif
                    </div>
                @endif
            </section>
            <aside class="space-y-5">
                <section class="panel p-5">
                    <p class="eyebrow mb-4">Make yourself at home</p>
                    <h2 class="text-base tracking-tight">A good place to begin.</h2>
                    <p class="text-xs muted leading-6 mt-2">The essentials are here. The next chapter is up to you.</p>
                    <div class="mt-5 space-y-4">
                        <div class="flex gap-3 items-center text-xs"><span
                                class="w-5 h-5 rounded-full grid place-items-center bg-success text-success-content"><x-icon
                                    name="check" size="xs" /></span><span class="muted">Create your
                                account</span></div>
                        <a href="{{ route('profile.edit') }}" x-navigate
                            class="flex gap-3 items-center text-xs hover:text-primary"><span
                                class="w-5 h-5 rounded-full border border-base-300 grid place-items-center text-[10px] muted">2</span>Make
                            your profile yours<x-icon name="chevron-right" size="xs" class="ml-auto" /></a>
                        <button type="button" class="flex gap-3 items-center text-xs text-left w-full hover:text-primary"
                            x-data @click="$dispatch('open-modal', 'create-project')"><span
                                class="w-5 h-5 rounded-full border border-base-300 grid place-items-center text-[10px] muted">3</span>Bring
                            an idea to life<x-icon name="chevron-right" size="xs" class="ml-auto" /></button>
                    </div>
                </section>
                <section class="rounded-xl bg-secondary border border-[#e3e0f2] p-5">
                    <span class="text-primary"><x-icon name="code" /></span>
                    <h2 class="text-sm font-medium mt-3">Small code. Big possibilities.</h2>
                    <p class="text-xs text-[#77728f] leading-6 mt-2">Explore the framework behind your workspace.</p><a
                        href="https://github.com/tinymvc/tinycore" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-xs text-primary mt-4">Meet Spark <x-icon
                            name="arrow-right" size="xs" /></a>
                </section>
            </aside>
        </div>
        <x-modal id="create-project" title="A new beginning." maxWidth="md">
            <p class="text-sm muted mb-6">Give your idea a name. The rest comes next.</p>
            <x-project-form />
        </x-modal>
        @foreach ($projects->items() as $project)
            <x-modal :id="'edit-project-' . $project->id" title="A little fine-tuning." maxWidth="md">
                <p class="text-sm muted mb-6">Update the details or mark your next milestone.</p>
                <x-project-form :$project :modalId="'edit-project-' . $project->id" />
            </x-modal>
            <x-modal :id="'delete-project-' . $project->id" title="Delete this project?" maxWidth="sm">
                <p class="text-sm muted mb-6">“{{ $project->name }}” will be permanently deleted. This can’t be undone.
                </p>
                <x-form :action="route('projects.destroy', ['id' => $project->id])" method="DELETE">
                    <div class="flex justify-end gap-2"><button type="button" class="btn btn-ghost"
                            @click="$dispatch('close-modal', 'delete-project-{{ $project->id }}')">Keep
                            project</button><button type="submit" class="btn bg-[#a32e36] border-[#a32e36] text-white"
                            :disabled="form.processing" x-text="form.processing ? 'Deleting…' : 'Delete project'">Delete
                            project</button></div>
                </x-form>
            </x-modal>
        @endforeach
    </x-layouts.app>
@endsection

@if (is_fire_js())
    @yield('content')
@endif

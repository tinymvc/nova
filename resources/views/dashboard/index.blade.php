@if (!is_fire_js())
    @extends('layouts.base')
@endif
@section('title')
    Overview · {{ config('app.name', 'Spark') }}
@endsection

@section('content')
    <x-layouts.app key="dashboard-{{ request()->url }}-{{ $total }}">
        <div class="flex items-center justify-between gap-4 mb-8">
            <div>
                <h1 data-page-heading tabindex="-1" class="page-title">Overview</h1>
                <p class="text-[13px] muted mt-1.5">Your projects, at a glance.</p>
            </div>
            <button type="button" class="btn btn-primary w-fit shrink-0" x-data
                @click="$dispatch('open-modal', 'create-project')">
                <x-icon name="plus" size="sm" /> New project
            </button>
        </div>

        <div class="grid grid-cols-3 gap-3 sm:gap-6 mb-8">
            <div class="panel p-4 sm:p-6">
                <div class="flex items-center justify-between gap-2">
                    <p class="min-h-8 sm:min-h-0 text-xs sm:text-[13px] muted">Total projects</p>
                    <span class="hidden sm:grid place-items-center size-8 rounded-lg bg-base-200 muted"><x-icon
                            name="folder" size="sm" /></span>
                </div>
                <p class="text-2xl sm:text-4xl leading-tight font-semibold tracking-tight tabular-nums mt-2">
                    {{ $total }}</p>
                <p class="text-[11px] sm:text-xs muted mt-1.5"><span
                        class="text-base-content font-medium">{{ $total - $inProgress - $completed }}</span> in planning</p>
            </div>
            <div class="panel p-4 sm:p-6">
                <div class="flex items-center justify-between gap-2">
                    <p class="min-h-8 sm:min-h-0 text-xs sm:text-[13px] muted">In progress</p>
                    <span
                        class="hidden sm:grid place-items-center size-8 rounded-lg bg-warning text-warning-content"><x-icon
                            name="chart-bar" size="sm" /></span>
                </div>
                <p class="text-2xl sm:text-4xl leading-tight font-semibold tracking-tight tabular-nums mt-2">
                    {{ $inProgress }}</p>
                <p class="text-[11px] sm:text-xs muted mt-1.5">In motion</p>
            </div>
            <div class="panel p-4 sm:p-6">
                <div class="flex items-center justify-between gap-2">
                    <p class="min-h-8 sm:min-h-0 text-xs sm:text-[13px] muted">Completed</p>
                    <span
                        class="hidden sm:grid place-items-center size-8 rounded-lg bg-success text-success-content"><x-icon
                            name="check" size="sm" /></span>
                </div>
                <p class="text-2xl sm:text-4xl leading-tight font-semibold tracking-tight tabular-nums mt-2">
                    {{ $completed }}</p>
                <p class="text-[11px] sm:text-xs muted mt-1.5"><span
                        class="text-base-content font-medium">{{ $total > 0 ? round(($completed / $total) * 100) : 0 }}%</span>
                    done</p>
            </div>
        </div>

        <section class="panel overflow-hidden" aria-labelledby="projects-heading">
            <div
                class="flex flex-col sm:flex-row justify-between gap-4 p-5 sm:px-6 border-b border-base-300 sm:items-center">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 id="projects-heading" class="text-sm font-semibold">Your projects</h2>
                        <span
                            class="bg-base-200 border border-base-300 text-xs muted rounded-md px-1.5 tabular-nums">{{ $total }}</span>
                    </div>
                </div>
                <form action="{{ route('dashboard') }}" method="get" class="flex gap-2" x-data="{ form: $form() }" x-form>
                    <label class="input input-sm flex items-center gap-2 w-full sm:w-48">
                        <x-icon name="search" size="sm" class="muted" />
                        <input name="q" value="{{ $search }}" placeholder="Search projects…"
                            aria-label="Search projects" maxlength="100">
                    </label>
                    <button class="btn btn-outline btn-sm" type="submit" :disabled="form.processing">Search</button>
                </form>
            </div>
            @if ($search)
                <div
                    class="px-6 py-3 border-b border-base-300 flex flex-wrap items-center justify-between gap-2 text-xs muted bg-base-200">
                    <span>Results for “{{ $search }}”</span>
                    <a href="{{ route('dashboard') }}" x-navigate class="text-link">Clear search <x-icon name="x-mark"
                            size="xs" /></a>
                </div>
            @endif
            @if ($projects->total() > 0)
                <div class="overflow-x-auto">
                    <table class="table w-full [&_tbody_tr:hover]:bg-base-200/50">
                        <thead>
                            <tr>
                                <th scope="col">Project name</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="hidden md:table-cell">Created</th>
                                <th scope="col" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects->items() as $project)
                                <tr key="project-{{ $project->id }}">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="hidden sm:grid place-items-center size-9 rounded-lg border border-base-300 bg-base-200 muted"><x-icon
                                                    name="folder" size="sm" /></span>
                                            <div class="min-w-0">
                                                <button type="button"
                                                    class="block font-medium max-w-28 sm:max-w-56 truncate text-left hover:text-primary"
                                                    x-data
                                                    @click="$dispatch('open-modal', 'edit-project-{{ $project->id }}')"
                                                    aria-label="Edit {{ $project->name }}">{{ $project->name }}</button>
                                                @if ($project->description)
                                                    <p class="text-xs muted mt-0.5 max-w-28 sm:max-w-56 truncate">
                                                        {{ $project->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-sm whitespace-nowrap {{ $project->status === 'completed' ? 'badge-success' : ($project->status === 'in_progress' ? 'badge-warning' : 'badge-secondary') }}">
                                            <span
                                                class="w-1 h-1 rounded-full bg-current"></span>{{ \App\Models\Project::STATUSES[$project->status] ?? 'Planning' }}
                                        </span>
                                    </td>
                                    <td class="hidden md:table-cell text-xs muted whitespace-nowrap">
                                        {{ $project->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <div class="flex justify-end items-center gap-1">
                                            <button type="button" class="hidden sm:inline-flex btn btn-ghost btn-sm muted"
                                                x-data @click="$dispatch('open-modal', 'edit-project-{{ $project->id }}')"
                                                aria-label="Edit details for {{ $project->name }}">Edit</button>
                                            <button type="button"
                                                class="btn btn-ghost btn-square btn-sm muted hover:text-error-content"
                                                x-data
                                                @click="$dispatch('open-modal', 'delete-project-{{ $project->id }}')"
                                                aria-label="Delete {{ $project->name }}"><x-icon name="trash"
                                                    size="sm" /></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 sm:px-6"><x-pagination :paginator="$projects" /></div>
            @else
                <div class="text-center px-6 py-16 sm:py-20">
                    <span class="icon-tile w-12! h-12! mx-auto mb-5"><x-icon :name="$search ? 'search' : 'folder'" size="lg" /></span>
                    <h3 class="text-sm font-semibold">
                        {{ $search ? 'No matching projects' : 'Your first project starts here' }}</h3>
                    <p class="text-[13px] muted mt-2 leading-6 max-w-72 mx-auto">
                        {{ $search ? 'Try another name or clear your search to see all your projects.' : 'Create a project to organize your ideas and keep track of what you’re building.' }}
                    </p>
                    @if ($search)
                        <a href="{{ route('dashboard') }}" x-navigate class="btn btn-outline btn-sm mt-5">Clear
                            search</a>
                    @else
                        <button type="button" class="btn btn-outline btn-sm mt-5" x-data
                            @click="$dispatch('open-modal', 'create-project')">
                            <x-icon name="plus" size="sm" /> Create a project
                        </button>
                    @endif
                </div>
            @endif
        </section>

        <div class="grid sm:grid-cols-2 gap-4 mt-6">
            <a href="https://tinymvc.github.io" target="_blank" rel="noopener noreferrer"
                class="panel flex items-center gap-4 p-5 hover:border-base-content/20 transition-colors">
                <span class="icon-tile shrink-0"><x-icon name="book-open" /></span>
                <div class="flex-1">
                    <h2 class="text-[13px] font-medium">Explore Spark</h2>
                    <p class="text-xs muted mt-1">Guides and tools for your next step.</p>
                </div>
                <x-icon name="arrow-up-right" size="sm" class="muted" />
            </a>
            <a href="{{ route('home') }}" x-navigate
                class="panel flex items-center gap-4 p-5 hover:border-base-content/20 transition-colors">
                <span class="icon-tile shrink-0"><x-icon name="flame" /></span>
                <div class="flex-1">
                    <h2 class="text-[13px] font-medium">Spark homepage</h2>
                    <p class="text-xs muted mt-1">Back to where your application begins.</p>
                </div>
                <x-icon name="arrow-right" size="sm" class="muted" />
            </a>
        </div>

        <x-modal id="create-project" title="Create a project" maxWidth="md">
            <p class="text-[13px] muted mb-6">Start with a name. You can always change the details later.</p>
            <x-project-form />
        </x-modal>
        @foreach ($projects->items() as $project)
            <x-modal :id="'edit-project-' . $project->id" title="Edit project" maxWidth="md">
                <p class="text-[13px] muted mb-6">Update your project details and track its progress.</p>
                <x-project-form :$project :modalId="'edit-project-' . $project->id" />
            </x-modal>
            <x-modal :id="'delete-project-' . $project->id" title="Delete project?" maxWidth="sm">
                <p class="text-sm muted mb-6">“{{ $project->name }}” will be permanently deleted. This can’t be undone.
                </p>
                <x-form :action="route('projects.destroy', ['id' => $project->id])" method="DELETE">
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-outline"
                            @click="$dispatch('close-modal', 'delete-project-{{ $project->id }}')">Cancel</button>
                        <button type="submit"
                            class="btn bg-error-content border-error-content text-white hover:opacity-90"
                            :disabled="form.processing" x-text="form.processing ? 'Deleting…' : 'Delete project'">Delete
                            project</button>
                    </div>
                </x-form>
            </x-modal>
        @endforeach
    </x-layouts.app>
@endsection

@if (is_fire_js())
    @yield('content')
@endif

@extends('layouts.app')
@section('title', 'Dashboard Overview')

@section('content')
    {{-- Page Header --}}
    <x-page-header title="Dashboard Overview" description="Welcome back, {{ user('name') }}! Here is a summary of your system metrics.">
        <x-button variant="outline" size="sm" icon="arrow-path" onclick="window.location.reload()">
            Refresh
        </x-button>
        <x-button variant="primary" size="sm" icon="plus" onclick="document.getElementById('new-project-modal').showModal()">
            New Project
        </x-button>
    </x-page-header>

    {{-- Metric Stat Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($stats as $stat)
            <div class="card bg-base-100 border border-base-200 shadow-sm p-5 rounded-2xl hover:border-primary/40 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-base-content/60 uppercase tracking-wider">{{ $stat['label'] }}</span>
                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                        <x-icon :name="$stat['icon']" size="xs" />
                    </div>
                </div>

                <div class="flex items-baseline justify-between">
                    <span class="text-2xl font-black text-base-content tracking-tight">{{ $stat['value'] }}</span>
                    <span class="inline-flex items-center text-xs font-semibold {{ $stat['trend'] === 'up' ? 'text-success' : 'text-error' }}">
                        {{ $stat['change'] }}
                    </span>
                </div>

                <p class="text-[11px] text-base-content/50 mt-1">{{ $stat['description'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Content Grid: Table & Activity Timeline --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Recent Records Table (2 cols on large screen) --}}
        <div class="lg:col-span-2">
            <div class="card bg-base-100 border border-base-200 shadow-sm rounded-2xl overflow-hidden">
                <div class="card-body p-6">
                    <div class="mb-4">
                        <h3 class="card-title text-lg font-bold text-base-content">Recent Registered Users</h3>
                        <p class="text-xs text-base-content/60 mt-0.5">Demonstration records with status tokens</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full text-left">
                            <thead>
                                <tr class="border-b border-base-200 text-xs text-base-content/60">
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $recUser)
                                    <tr class="hover:bg-base-200/50 transition-colors">
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <x-avatar :name="$recUser['name']" size="xs" />
                                                <div>
                                                    <div class="font-bold text-sm">{{ $recUser['name'] }}</div>
                                                    <div class="text-xs text-base-content/60">{{ $recUser['email'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-xs font-medium">{{ $recUser['role'] }}</span>
                                        </td>
                                        <td>
                                            @if($recUser['status'] === 'Active')
                                                <x-badge variant="success" size="xs">Active</x-badge>
                                            @elseif($recUser['status'] === 'Pending')
                                                <x-badge variant="warning" size="xs">Pending</x-badge>
                                            @else
                                                <x-badge variant="neutral" size="xs">Inactive</x-badge>
                                            @endif
                                        </td>
                                        <td class="text-xs text-base-content/70">
                                            {{ $recUser['joined'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity Timeline (1 col on large screen) --}}
        <div class="lg:col-span-1">
            <div class="card bg-base-100 border border-base-200 shadow-sm rounded-2xl p-6">
                <div class="mb-4">
                    <h3 class="card-title text-lg font-bold text-base-content">Recent Activity</h3>
                    <p class="text-xs text-base-content/60 mt-0.5">Live events stream</p>
                </div>

                <div class="space-y-4">
                    @foreach($recentActivity as $activity)
                        <div class="flex items-start gap-3 text-xs">
                            <div class="w-2 h-2 rounded-full mt-1.5 shrink-0 bg-primary"></div>
                            <div class="min-w-0 flex-1">
                                <p class="text-base-content font-medium leading-relaxed">
                                    <span class="font-bold">{{ $activity['user'] }}</span>
                                    {{ $activity['action'] }}
                                </p>
                                <span class="text-base-content/50 text-[10px]">{{ $activity['time'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Interactive Showcase Modal Demo --}}
    <x-modal id="new-project-modal" title="Create New Project" maxWidth="md">
        <form method="dialog" class="space-y-4">
            <x-input name="project_name" label="Project Name" placeholder="e.g. Acme Marketing Site" required />
            <x-textarea name="project_description" label="Description" placeholder="Brief overview of project goals..." rows="3" />
            
            <div class="flex justify-end gap-2 pt-2">
                <x-button type="submit" variant="ghost" size="sm">Cancel</x-button>
                <x-button type="submit" variant="primary" size="sm">Save Project</x-button>
            </div>
        </form>
    </x-modal>
@endsection

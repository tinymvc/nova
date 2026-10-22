@props(['project' => null, 'modalId' => 'create-project'])
<x-form :action="$project ? route('projects.update', ['id' => $project->id]) : route('projects.store')" :method="$project ? 'PATCH' : 'POST'">
    <x-input name="name" :id="$modalId . '-name'" label="Project name" :value="$project?->name" placeholder="e.g. Website redesign"
        maxlength="100" required autofocus />
    <x-textarea name="description" :id="$modalId . '-description'" label="Description (optional)" :value="$project?->description" rows="3"
        maxlength="500" placeholder="A short description of your project" />
    <x-select name="status" :id="$modalId . '-status'" label="Status" :options="\App\Models\Project::STATUSES" :selected="$project?->status ?? 'planning'" />
    <div class="flex justify-end gap-2 pt-5 border-t border-base-300">
        <button type="button" class="btn btn-outline"
            @click="$dispatch('close-modal', '{{ $modalId }}')">Cancel</button>
        <x-submit :label="$project ? 'Save changes' : 'Create project'" />
    </div>
</x-form>

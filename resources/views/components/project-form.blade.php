@props(['project' => null, 'modalId' => 'create-project'])
<x-form :action="$project ? route('projects.update', ['id' => $project->id]) : route('projects.store')" :method="$project ? 'PATCH' : 'POST'">
    <x-input name="name" :id="$modalId . '-name'" label="Project name" :value="$project?->name" placeholder="Something wonderful"
        maxlength="100" required autofocus />
    <div>
        <label for="{{ $modalId }}-description" class="block text-xs font-medium mb-2">A few words <span
                class="muted font-normal">(optional)</span></label>
        <textarea id="{{ $modalId }}-description" name="description" class="textarea w-full" rows="3" maxlength="500"
            placeholder="What do you have in mind?">{{ old('description', $project?->description) }}</textarea>
        <x-error field="description" />
    </div>
    <div>
        <label for="{{ $modalId }}-status" class="block text-xs font-medium mb-2">Status</label>
        <select name="status" id="{{ $modalId }}-status" class="select w-full">
            @foreach (\App\Models\Project::STATUSES as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $project?->status ?? 'planning') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-error field="status" />
    </div>
    <div class="flex justify-end gap-2 pt-2">
        <button type="button" class="btn btn-ghost"
            @click="$dispatch('close-modal', '{{ $modalId }}')">Cancel</button>
        <x-submit :label="$project ? 'Save changes' : 'Create project'" />
    </div>
</x-form>

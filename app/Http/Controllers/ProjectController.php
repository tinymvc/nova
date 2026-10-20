<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Spark\Facades\Auth;
use Spark\Http\Response;

class ProjectController extends Controller
{
    public function store(ProjectRequest $request): Response
    {
        Project::create($request->validated()->merge([
            'user_id' => Auth::id(),
        ]));

        return fire()->navigate((string) route('dashboard'))
            ->with('status', 'Project created. Make something great.');
    }

    public function destroy(int $id): Response
    {
        $project = Project::ownedBy(Auth::id())->findOrFail($id);

        if (!$project->remove()) {
            abort(500, 'Unable to delete this project.');
        }

        return fire()->navigate((string) route('dashboard'))
            ->with('status', 'Project deleted.');
    }

    public function update(ProjectRequest $request, int $id): Response
    {
        $project = Project::ownedBy(Auth::id())->findOrFail($id);

        if (!$project->fill($request->validated())->save()) {
            abort(500, 'Unable to update this project.');
        }

        return fire()->navigate((string) route('dashboard'))
            ->with('status', 'Project updated. Keep the momentum going.');
    }
}

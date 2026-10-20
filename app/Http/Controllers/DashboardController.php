<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Spark\Facades\Auth;
use Spark\Http\Request;
use Spark\Http\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->validate(['q' => 'nullable|string|max:100']);
        $query = Project::ownedBy(Auth::id());

        if ($filters->string('q') !== null && $filters->string('q') !== '') {
            $query->whereContains('name', $filters->string('q'));
        }

        return fire('dashboard.index', [
            'projects' => $query->latest()->paginate(8),
            'search' => $filters->string('q') ?? '',
            'total' => Project::ownedBy(Auth::id())->count(),
            'inProgress' => Project::ownedBy(Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Project::ownedBy(Auth::id())->where('status', 'completed')->count(),
        ]);
    }
}

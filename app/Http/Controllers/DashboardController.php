<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Spark\Facades\Auth;
use Spark\Fire\Fire;
use Spark\Http\Request;
use Spark\Http\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $keyword = $request->validate(['q' => 'nullable|string|max:100'])
            ->string('q') ?: '';

        $query = Project::ownedBy(Auth::id());

        if ($keyword !== '') {
            $query->whereContains('name', $keyword);
        }

        return Fire::render('dashboard.index', [
            'projects' => $query->latest()->paginate(8),
            'search' => $keyword,
            'total' => Project::ownedBy(Auth::id())->count(),
            'inProgress' => Project::ownedBy(Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Project::ownedBy(Auth::id())->where('status', 'completed')->count(),
        ]);
    }
}

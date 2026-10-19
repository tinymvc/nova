<?php

namespace App\Http\Controllers;

use Spark\Facades\Auth;
use Spark\Http\Response;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): Response
    {
        $user = Auth::user();

        // Explicitly labeled demonstration data for Nova dashboard overview
        $stats = [
            [
                'label' => 'Total Revenue',
                'value' => '$48,250',
                'change' => '+12.5%',
                'trend' => 'up',
                'icon' => 'chart-bar',
                'description' => 'vs last month',
            ],
            [
                'label' => 'Active Users',
                'value' => '2,420',
                'change' => '+18.2%',
                'trend' => 'up',
                'icon' => 'users',
                'description' => 'vs last month',
            ],
            [
                'label' => 'Total Orders',
                'value' => '1,280',
                'change' => '-3.1%',
                'trend' => 'down',
                'icon' => 'dashboard',
                'description' => 'vs last month',
            ],
            [
                'label' => 'System Uptime',
                'value' => '99.98%',
                'change' => '+0.01%',
                'trend' => 'up',
                'icon' => 'shield-check',
                'description' => 'trailing 30 days',
            ],
        ];

        $recentActivity = [
            [
                'user' => 'Sarah Connor',
                'action' => 'deployed release v1.2.0 to production',
                'time' => '15 minutes ago',
                'type' => 'success',
            ],
            [
                'user' => 'Alex Developer',
                'action' => 'modified API rate limits in production',
                'time' => '42 minutes ago',
                'type' => 'warning',
            ],
            [
                'user' => 'Elena Fisher',
                'action' => 'created a new database migration',
                'time' => '2 hours ago',
                'type' => 'info',
            ],
            [
                'user' => 'John Doe',
                'action' => 'updated security credentials',
                'time' => '5 hours ago',
                'type' => 'neutral',
            ],
        ];

        $recentUsers = [
            [
                'name' => 'Sophia Martinez',
                'email' => 'sophia@example.com',
                'role' => 'Administrator',
                'status' => 'Active',
                'joined' => 'Oct 15, 2026',
            ],
            [
                'name' => 'Liam Johnson',
                'email' => 'liam@example.com',
                'role' => 'Editor',
                'status' => 'Active',
                'joined' => 'Oct 14, 2026',
            ],
            [
                'name' => 'Olivia Smith',
                'email' => 'olivia@example.com',
                'role' => 'Member',
                'status' => 'Pending',
                'joined' => 'Oct 12, 2026',
            ],
            [
                'name' => 'Noah Williams',
                'email' => 'noah@example.com',
                'role' => 'Member',
                'status' => 'Inactive',
                'joined' => 'Oct 10, 2026',
            ],
        ];

        return view('dashboard.index', [
            'user' => $user,
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'recentUsers' => $recentUsers,
        ]);
    }
}

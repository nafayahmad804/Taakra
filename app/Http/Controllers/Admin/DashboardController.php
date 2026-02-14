<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Registration;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_competitions' => Competition::count(),
            'total_registrations' => Registration::count(),
            'pending_registrations' => Registration::where('status', 'pending')->count(),
            'active_competitions' => Competition::where('status', 'published')->count(),
            'total_categories' => Category::count(),
        ];

        $recent_registrations = Registration::with(['user', 'competition'])
            ->latest()
            ->take(10)
            ->get();

        $top_competitions = Competition::withCount('confirmedRegistrations')
            ->orderByDesc('confirmed_registrations_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_registrations', 'top_competitions'));
    }
}

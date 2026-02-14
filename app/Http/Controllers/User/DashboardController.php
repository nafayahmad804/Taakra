<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $registrations = Registration::where('user_id', $user->id)
            ->with('competition.category')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_registrations' => Registration::where('user_id', $user->id)->count(),
            'confirmed' => Registration::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'pending' => Registration::where('user_id', $user->id)->where('status', 'pending')->count(),
        ];

        return view('user.dashboard', compact('registrations', 'stats'));
    }
}

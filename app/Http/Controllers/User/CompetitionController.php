<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    public function index(Request $request)
    {
        $query = Competition::where('status', 'published')->with('category');

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'trending':
                    $query->trending();
                    break;
                case 'most_registrations':
                    $query->mostRegistrations();
                    break;
                case 'new':
                default:
                    $query->new();
                    break;
            }
        } else {
            $query->new();
        }

        $competitions = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('user.competitions.index', compact('competitions', 'categories'));
    }

    public function show(Competition $competition)
    {
        if ($competition->status !== 'published') {
            abort(404);
        }

        $competition->increment('views');
        $competition->load('category');

        $isRegistered = Registration::where('user_id', Auth::id())
            ->where('competition_id', $competition->id)
            ->exists();

        $registrationCount = $competition->confirmedRegistrations()->count();

        return view('user.competitions.show', compact('competition', 'isRegistered', 'registrationCount'));
    }

    public function register(Competition $competition)
    {
        if ($competition->status !== 'published') {
            return back()->with('error', 'Cannot register for this competition');
        }

        if (Registration::where('user_id', Auth::id())->where('competition_id', $competition->id)->exists()) {
            return back()->with('error', 'Already registered');
        }

        if ($competition->max_participants) {
            $currentCount = $competition->confirmedRegistrations()->count();
            if ($currentCount >= $competition->max_participants) {
                return back()->with('error', 'Competition is full');
            }
        }

        if ($competition->registration_deadline < now()) {
            return back()->with('error', 'Registration deadline has passed');
        }

        Registration::create([
            'user_id' => Auth::id(),
            'competition_id' => $competition->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Registration submitted successfully');
    }

    public function myCompetitions()
    {
        $registrations = Registration::where('user_id', Auth::id())
            ->with(['competition.category'])
            ->latest()
            ->paginate(10);

        return view('user.competitions.my-competitions', compact('registrations'));
    }
    public function calendar()
    {
        return view('user.competitions.calendar');
    }
}

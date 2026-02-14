<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'competition']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->paginate(20);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function confirm(Registration $registration)
    {
        $registration->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::id()
        ]);

        return back()->with('success', 'Registration confirmed successfully');
    }

    public function reject(Registration $registration)
    {
        $registration->update(['status' => 'rejected']);
        return back()->with('success', 'Registration rejected successfully');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return back()->with('success', 'Registration deleted successfully');
    }
}

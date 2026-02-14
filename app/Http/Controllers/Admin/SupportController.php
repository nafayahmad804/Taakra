<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupportController extends Controller
{
    public function index()
    {
        $supportMembers = SupportMember::with('user')->latest()->paginate(15);
        return view('admin.support.index', compact('supportMembers'));
    }

    public function create()
    {
        return view('admin.support.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'specialization' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'support'
        ]);

        SupportMember::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'] ?? null,
            'is_active' => true
        ]);

        return redirect()->route('admin.support.index')
            ->with('success', 'Support member added successfully');
    }

    public function edit(SupportMember $support)
    {
        return view('admin.support.edit', compact('support'));
    }

    public function update(Request $request, SupportMember $support)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $support->user->update(['name' => $validated['name']]);
        $support->update([
            'specialization' => $validated['specialization'] ?? null,
            'is_active' => $validated['is_active'] ?? true
        ]);

        return redirect()->route('admin.support.index')
            ->with('success', 'Support member updated successfully');
    }

    public function destroy(SupportMember $support)
    {
        $user = $support->user;
        $support->delete();
        $user->delete();

        return redirect()->route('admin.support.index')
            ->with('success', 'Support member deleted successfully');
    }
}

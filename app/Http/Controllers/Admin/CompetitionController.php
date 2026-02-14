<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::with('category')
            ->withCount('confirmedRegistrations')
            ->latest()
            ->paginate(15);
        return view('admin.competitions.index', compact('competitions'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.competitions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'nullable|string',
            'prizes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'entry_fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,ongoing,completed,cancelled'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('competitions', 'public');
        }

        Competition::create($validated);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition created successfully');
    }

    public function edit(Competition $competition)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.competitions.edit', compact('competition', 'categories'));
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'nullable|string',
            'prizes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:start_date',
            'max_participants' => 'nullable|integer|min:1',
            'entry_fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,ongoing,completed,cancelled'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($competition->image) {
                Storage::disk('public')->delete($competition->image);
            }
            $validated['image'] = $request->file('image')->store('competitions', 'public');
        }

        $competition->update($validated);

        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition updated successfully');
    }

    public function destroy(Competition $competition)
    {
        if ($competition->image) {
            Storage::disk('public')->delete($competition->image);
        }

        $competition->delete();
        return redirect()->route('admin.competitions.index')
            ->with('success', 'Competition deleted successfully');
    }
}

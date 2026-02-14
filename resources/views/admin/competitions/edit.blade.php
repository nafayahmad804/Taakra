@extends('admin.layouts.app')
@section('title', 'Edit Competition')
@section('content')
<div class="content-card" style="max-width: 900px;">
    <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 24px;">Edit Competition</h2>
    <form action="{{ route('admin.competitions.update', $competition) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $competition->title) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $competition->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Description *</label>
            <textarea name="description" class="form-control" required>{{ old('description', $competition->description) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Rules</label>
            <textarea name="rules" class="form-control">{{ old('rules', $competition->rules) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Prizes</label>
            <textarea name="prizes" class="form-control">{{ old('prizes', $competition->prizes) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Competition Image</label>
            @if($competition->image)
            <div style="margin-bottom: 10px;">
                <img src="{{ asset('storage/' . $competition->image) }}" style="max-width: 200px; border-radius: 8px;">
            </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Start Date *</label>
                <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', $competition->start_date->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">End Date *</label>
                <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $competition->end_date->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Registration Deadline *</label>
                <input type="datetime-local" name="registration_deadline" class="form-control" value="{{ old('registration_deadline', $competition->registration_deadline->format('Y-m-d\TH:i')) }}" required>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Max Participants</label>
                <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants', $competition->max_participants) }}" min="1">
            </div>
            <div class="form-group">
                <label class="form-label">Entry Fee</label>
                <input type="number" step="0.01" name="entry_fee" class="form-control" value="{{ old('entry_fee', $competition->entry_fee) }}" min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ old('status', $competition->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $competition->status) == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="ongoing" {{ old('status', $competition->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ old('status', $competition->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $competition->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Update Competition</button>
            <a href="{{ route('admin.competitions.index') }}" class="btn-danger" style="text-decoration: none;"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
@endsection

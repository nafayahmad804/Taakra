@extends('admin.layouts.app')

@section('title', 'Create Competition')

@section('content')
<div class="content-card" style="max-width: 900px;">
    <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 24px;">Create New Competition</h2>

    <form action="{{ route('admin.competitions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Description *</label>
            <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
            @error('description')
            <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Rules</label>
            <textarea name="rules" class="form-control">{{ old('rules') }}</textarea>
            @error('rules')
            <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Prizes</label>
            <textarea name="prizes" class="form-control">{{ old('prizes') }}</textarea>
            @error('prizes')
            <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Competition Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @error('image')
            <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Start Date *</label>
                <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                @error('start_date')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">End Date *</label>
                <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                @error('end_date')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Registration Deadline *</label>
                <input type="datetime-local" name="registration_deadline" class="form-control" value="{{ old('registration_deadline') }}" required>
                @error('registration_deadline')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Max Participants</label>
                <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants') }}" min="1">
                @error('max_participants')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Entry Fee</label>
                <input type="number" step="0.01" name="entry_fee" class="form-control" value="{{ old('entry_fee', 0) }}" min="0">
                @error('entry_fee')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Create Competition
            </button>
            <a href="{{ route('admin.competitions.index') }}" class="btn-danger" style="text-decoration: none;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
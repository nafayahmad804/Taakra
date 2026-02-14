@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="content-card" style="max-width: 800px;">
    <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 24px;">Create New Category</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
            <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
            <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Icon (Font Awesome class)</label>
            <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="fas fa-trophy">
            <small style="color: #6c757d;">Example: fas fa-trophy, fas fa-code, fas fa-paint-brush</small>
            @error('icon')
            <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <span>Active</span>
            </label>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Create Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn-danger" style="text-decoration: none;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
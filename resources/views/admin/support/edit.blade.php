@extends('admin.layouts.app')
@section('title', 'Edit Support Member')
@section('content')
<div class="content-card" style="max-width: 800px;">
    <h2 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 24px;">Edit Support Member</h2>
    <form action="{{ route('admin.support.update', $support) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $support->user->name) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ $support->user->email }}" disabled>
        </div>
        <div class="form-group">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $support->specialization) }}">
        </div>
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $support->is_active) ? 'checked' : '' }}>
                <span>Active</span>
            </label>
        </div>
        <div style="display: flex; gap: 12px; margin-top: 30px;">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Update Member</button>
            <a href="{{ route('admin.support.index') }}" class="btn-danger" style="text-decoration: none;"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
@endsection